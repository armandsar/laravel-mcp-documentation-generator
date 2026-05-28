<?php

namespace Sezy\LaravelMcpDocumentationGenerator\Tests\Fixtures;

use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Attributes\Instructions;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Version;
use Laravel\Mcp\Server\Tool;

#[Name('Panda Pockets Company MCP Server')]
#[Version('1.2.3')]
#[Instructions('Use these tools to manage company data.')]
class CompanyMcpServer extends Server
{
    /** @var array<int, class-string<Tool>> */
    protected array $tools = [
        FindEmployeeTool::class,
    ];
}
