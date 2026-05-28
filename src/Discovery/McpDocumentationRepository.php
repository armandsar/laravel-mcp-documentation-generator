<?php

namespace Sezy\LaravelMcpDocumentationGenerator\Discovery;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route as Router;
use Illuminate\Support\Str;
use Laravel\Mcp\Facades\Mcp;
use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Attributes\Instructions;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\ServerAttribute;
use Laravel\Mcp\Server\Attributes\Version;
use Laravel\Mcp\Server\ServerContext;
use ReflectionFunction;
use ReflectionObject;
use Sezy\LaravelMcpDocumentationGenerator\Support\NullTransport;
use Stringable;
use Throwable;

class McpDocumentationRepository
{
    /**
     * @return array<int, array{
     *     uri: string,
     *     path: string,
     *     url: string,
     *     class: class-string<Server>,
     *     anchor: string,
     *     name: string,
     *     version: string,
     *     instructions: string,
     *     tools: array<int, array<string, mixed>>
     * }>
     */
    public function servers(): array
    {
        if (! class_exists(Mcp::class)) {
            return [];
        }

        /** @var list<array{uri: string, path: string, url: string, class: class-string<Server>, anchor: string, name: string, version: string, instructions: string, tools: array<int, array<string, mixed>>}> $servers */
        $servers = [];

        foreach ($this->webServerRoutes() as $route) {
            $serverClass = $this->serverClassFromRoute($route);

            if ($serverClass === null || ! is_subclass_of($serverClass, Server::class)) {
                continue;
            }

            if (! $this->shouldInclude($serverClass)) {
                continue;
            }

            $entry = $this->serverEntry($route, $serverClass, count($servers));

            if ($entry !== null) {
                $servers[] = $entry;
            }
        }

        return $servers;
    }

    /**
     * @return list<Route>
     */
    protected function webServerRoutes(): array
    {
        $routes = [];
        $discoveredUris = [];

        foreach (Mcp::servers() as $route) {
            if (! $route instanceof Route) {
                continue;
            }

            $routes[] = $route;
            $discoveredUris[$route->uri()] = true;
        }

        foreach (Router::getRoutes()->getRoutes() as $route) {
            if (isset($discoveredUris[$route->uri()])) {
                continue;
            }

            if ($this->serverClassFromRoute($route) === null) {
                continue;
            }

            $routes[] = $route;
            $discoveredUris[$route->uri()] = true;
        }

        return $routes;
    }

    /**
     * @return class-string<Server>|null
     */
    protected function serverClassFromRoute(Route $route): ?string
    {
        $uses = $route->getAction('uses');

        if (! $uses instanceof Closure) {
            return null;
        }

        foreach ((new ReflectionFunction($uses))->getStaticVariables() as $value) {
            if (is_string($value) && is_subclass_of($value, Server::class)) {
                return $value;
            }
        }

        return null;
    }

    /**
     * @param  class-string<Server>  $serverClass
     * @return array{
     *     uri: string,
     *     path: string,
     *     url: string,
     *     class: class-string<Server>,
     *     anchor: string,
     *     name: string,
     *     version: string,
     *     instructions: string,
     *     tools: array<int, array<string, mixed>>
     * }|null
     */
    protected function serverEntry(Route $route, string $serverClass, int $serverIndex): ?array
    {
        try {
            $server = Container::getInstance()->make($serverClass, [
                'transport' => new NullTransport,
            ]);

            if (! $server instanceof Server) {
                return null;
            }

            $server->start();

            $context = $server->createContext();
            $metadata = $this->serverMetadata($server);
            $path = '/'.ltrim($route->uri(), '/');
            $serverAnchorKey = $this->serverAnchorKey($path, $metadata['name'], $serverIndex);
            $tools = $this->toolEntries($context, $serverClass, $route, $serverAnchorKey);
        } catch (Throwable $e) {
            Log::warning('Unable to inspect MCP server for documentation.', [
                'server' => $serverClass,
                'route' => $route->uri(),
                'exception' => $e,
            ]);

            return null;
        }

        return [
            'uri' => $route->uri(),
            'path' => $path,
            'url' => url('/'.ltrim($route->uri(), '/')),
            'class' => $serverClass,
            'anchor' => 'server-'.$serverAnchorKey,
            'name' => $metadata['name'],
            'version' => $metadata['version'],
            'instructions' => $metadata['instructions'],
            'tools' => $tools,
        ];
    }

    /**
     * @param  class-string<Server>  $serverClass
     * @return array<int, array<string, mixed>>
     */
    protected function toolEntries(ServerContext $context, string $serverClass, Route $route, string $serverAnchorKey): array
    {
        $tools = [];

        foreach ($context->tools() as $toolIndex => $tool) {
            try {
                $entry = $tool->toArray();
                $toolAnchorKey = $this->toolAnchorKey($entry['name'], $toolIndex);
                $entry['anchor'] = 'tool-'.$serverAnchorKey.'-'.$toolAnchorKey;

                $tools[] = $entry;
            } catch (Throwable $e) {
                Log::warning('Unable to inspect MCP tool for documentation.', [
                    'server' => $serverClass,
                    'route' => $route->uri(),
                    'tool' => $tool->name(),
                    'exception' => $e,
                ]);
            }
        }

        return $tools;
    }

    protected function serverAnchorKey(string $path, string $name, int $serverIndex): string
    {
        $source = $path !== '' ? $path : $name;
        $source = str_replace(['/', '\\'], ' ', trim($source, '/\\'));

        return Str::slug($source) ?: 'server-'.$serverIndex;
    }

    protected function toolAnchorKey(string $name, int $toolIndex): string
    {
        return Str::slug($name) ?: 'tool-'.$toolIndex;
    }

    /**
     * @param  class-string<Server>  $serverClass
     */
    protected function shouldInclude(string $serverClass): bool
    {
        $filters = config('mcp-documentation-generator.servers', []);

        if (! is_array($filters) || $filters === []) {
            return true;
        }

        foreach ($filters as $filter) {
            if (is_string($filter) && $filter === $serverClass) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array{name: string, version: string, instructions: string}
     */
    protected function serverMetadata(Server $server): array
    {
        return [
            'name' => $this->serverAttribute($server, Name::class) ?? $this->serverProperty($server, 'name', ''),
            'version' => $this->serverAttribute($server, Version::class) ?? $this->serverProperty($server, 'version', '1.0.0'),
            'instructions' => $this->serverAttribute($server, Instructions::class) ?? $this->serverProperty($server, 'instructions', ''),
        ];
    }

    /**
     * @param  class-string<ServerAttribute>  $attribute
     */
    protected function serverAttribute(Server $server, string $attribute): ?string
    {
        $attributes = (new ReflectionObject($server))->getAttributes($attribute);

        if ($attributes === []) {
            return null;
        }

        return $attributes[0]->newInstance()->value;
    }

    protected function serverProperty(Server $server, string $property, string $default): string
    {
        $reflection = new ReflectionObject($server);

        if (! $reflection->hasProperty($property)) {
            return $default;
        }

        $value = $reflection->getProperty($property)->getValue($server);

        if (is_scalar($value) || $value instanceof Stringable) {
            return (string) $value;
        }

        return $default;
    }
}
