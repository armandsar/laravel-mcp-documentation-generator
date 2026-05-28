<?php

namespace Sezy\LaravelMcpDocumentationGenerator\Tests\Fixtures;

use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Tool;

class BootConfiguredMcpServer extends Server
{
    protected string $name = 'Boot Configured MCP';

    /** @var array<int, class-string<Tool>> */
    protected array $tools = [];

    protected function boot(): void
    {
        $this->tools = [
            PingOtherTool::class,
        ];
    }
}
