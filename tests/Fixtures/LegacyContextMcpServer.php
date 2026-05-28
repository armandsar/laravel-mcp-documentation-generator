<?php

namespace Sezy\LaravelMcpDocumentationGenerator\Tests\Fixtures;

use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Attributes\Instructions;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Version;
use Laravel\Mcp\Server\ServerContext;

#[Name('Legacy Context MCP')]
#[Version('2.0.0')]
#[Instructions('Legacy context instructions.')]
class LegacyContextMcpServer extends Server
{
    public function createContext(): ServerContext
    {
        $context = parent::createContext();

        unset($context->implementation);

        return $context;
    }
}
