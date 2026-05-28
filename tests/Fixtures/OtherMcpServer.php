<?php

namespace Sezy\LaravelMcpDocumentationGenerator\Tests\Fixtures;

use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Tool;

class OtherMcpServer extends Server
{
    protected string $name = 'Other MCP';

    protected string $version = '9.9.9';

    protected string $instructions = 'Use these tools for other workflows.';

    /** @var array<int, class-string<Tool>> */
    protected array $tools = [
        PingOtherTool::class,
    ];
}
