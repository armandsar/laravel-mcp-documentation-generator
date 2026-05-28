<?php

use Laravel\Mcp\Facades\Mcp;
use Sezy\LaravelMcpDocumentationGenerator\Tests\Fixtures\CompanyMcpServer;
use Sezy\LaravelMcpDocumentationGenerator\Tests\Fixtures\OtherMcpServer;

it('renders rich html documentation for registered web mcp servers', function () {
    config()->set('app.name', 'Panda Pockets');

    Mcp::web('/mcp/company', CompanyMcpServer::class);
    Mcp::web('/mcp/other', OtherMcpServer::class);

    $this->get('/docs/mcp')
        ->assertOk()
        ->assertSee('Panda Pockets MCP docs')
        ->assertSee('Panda Pockets Company MCP Server')
        ->assertSee('/mcp/company')
        ->assertDontSee(CompanyMcpServer::class)
        ->assertSee('Use these tools to manage company data.')
        ->assertSee('find-employee')
        ->assertSee('Find an employee by email address.')
        ->assertSee('Employee email address')
        ->assertSee('Other MCP')
        ->assertSee('/mcp/other')
        ->assertSee('ping-other');
});

it('renders full server urls with copy buttons', function () {
    Mcp::web('/mcp/company', CompanyMcpServer::class);

    $this->get('/docs/mcp')
        ->assertOk()
        ->assertSee(url('/mcp/company'))
        ->assertSee('data-copy-value="'.url('/mcp/company').'"', false)
        ->assertSee('Copy');
});

it('renders sidebar links to servers and tools', function () {
    Mcp::web('/mcp/company', CompanyMcpServer::class);
    Mcp::web('/mcp/other', OtherMcpServer::class);

    $this->get('/docs/mcp')
        ->assertOk()
        ->assertSee('href="#server-mcp-company"', false)
        ->assertSee('id="server-mcp-company"', false)
        ->assertSee('Tools')
        ->assertSee('href="#tool-mcp-company-find-employee"', false)
        ->assertSee('id="tool-mcp-company-find-employee"', false)
        ->assertSee('href="#server-mcp-other"', false)
        ->assertSee('href="#tool-mcp-other-ping-other"', false);
});

it('renders raw json schema blocks', function () {
    Mcp::web('/mcp/company', CompanyMcpServer::class);

    $this->get('/docs/mcp')
        ->assertOk()
        ->assertSee('"type": "object"');
});

it('renders an empty state when no web mcp servers are available', function () {
    $this->get('/docs/mcp')
        ->assertOk()
        ->assertSee('No MCP web servers found.');
});
