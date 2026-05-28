<?php

namespace Sezy\LaravelMcpDocumentationGenerator\Tests\Fixtures;

use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Tool;

class OtherBrokenSchemaMcpServer extends Server
{
    protected string $name = 'Other Broken Schema MCP';

    /** @var array<int, class-string<Tool>> */
    protected array $tools = [
        BrokenSchemaTool::class,
    ];
}
