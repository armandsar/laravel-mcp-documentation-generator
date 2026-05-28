<?php

namespace Sezy\LaravelMcpDocumentationGenerator\Tests\Fixtures;

use Laravel\Mcp\Server\Tool;

class PingOtherTool extends Tool
{
    protected string $name = 'ping-other';

    protected string $description = 'Ping the other server.';
}
