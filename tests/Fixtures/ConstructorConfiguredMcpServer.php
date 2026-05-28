<?php

namespace Sezy\LaravelMcpDocumentationGenerator\Tests\Fixtures;

use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Contracts\Transport;
use Laravel\Mcp\Server\Tool;

class ConstructorConfiguredMcpServer extends Server
{
    /** @var array<int, class-string<Tool>> */
    protected array $tools = [];

    public function __construct(Transport $transport)
    {
        parent::__construct($transport);

        $this->name = 'Constructor MCP';
        $this->tools = [
            PingOtherTool::class,
        ];
    }
}
