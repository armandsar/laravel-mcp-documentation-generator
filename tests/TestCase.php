<?php

namespace Sezy\LaravelMcpDocumentationGenerator\Tests;

use Illuminate\Routing\RouteCollection;
use Orchestra\Testbench\TestCase as Orchestra;
use Sezy\LaravelMcpDocumentationGenerator\LaravelMcpDocumentationGeneratorServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            LaravelMcpDocumentationGeneratorServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('mcp-documentation-generator.enabled', true);
        $app['config']->set('database.default', 'testing');
    }

    public function reloadDocumentationRoutesWithConfig(array $config): void
    {
        foreach ($config as $key => $value) {
            config()->set('mcp-documentation-generator.'.$key, $value);
        }

        $this->app['router']->setRoutes(new RouteCollection);

        require __DIR__.'/../routes/web.php';
    }
}
