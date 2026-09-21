<?php

namespace Sezy\LaravelMcpDocumentationGenerator\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use LogicException;
use Sezy\LaravelMcpDocumentationGenerator\Discovery\McpDocumentationRepository;

class McpDocumentationController
{
    public function __invoke(McpDocumentationRepository $repository, Factory $views): View
    {
        return $this->render($views, 'mcp-documentation-generator::index', [
            'servers' => $repository->servers(),
        ]);
    }

    /** @param array<string, mixed> $data */
    private function render(Factory $views, string $view, array $data): View
    {
        if (! $views->exists($view)) {
            throw new LogicException('The MCP documentation view is not registered.');
        }

        return $views->make($view, $data);
    }
}
