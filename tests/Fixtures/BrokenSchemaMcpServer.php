<?php

namespace Sezy\LaravelMcpDocumentationGenerator\Tests\Fixtures;

use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Tool;

class BrokenSchemaMcpServer extends Server
{
    protected string $name = 'Broken Schema MCP';

    /** @var array<int, class-string<Tool>> */
    protected array $tools = [
        BrokenSchemaTool::class,
    ];
}
