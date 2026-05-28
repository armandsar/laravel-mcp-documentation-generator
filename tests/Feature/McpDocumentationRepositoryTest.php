<?php

use Illuminate\Support\Facades\Log;
use Laravel\Mcp\Facades\Mcp;
use Sezy\LaravelMcpDocumentationGenerator\Discovery\McpDocumentationRepository;
use Sezy\LaravelMcpDocumentationGenerator\Tests\Fixtures\BootConfiguredMcpServer;
use Sezy\LaravelMcpDocumentationGenerator\Tests\Fixtures\BrokenSchemaMcpServer;
use Sezy\LaravelMcpDocumentationGenerator\Tests\Fixtures\CompanyMcpServer;
use Sezy\LaravelMcpDocumentationGenerator\Tests\Fixtures\ConstructorConfiguredMcpServer;
use Sezy\LaravelMcpDocumentationGenerator\Tests\Fixtures\LegacyContextMcpServer;
use Sezy\LaravelMcpDocumentationGenerator\Tests\Fixtures\OtherBrokenSchemaMcpServer;
use Sezy\LaravelMcpDocumentationGenerator\Tests\Fixtures\OtherMcpServer;

beforeEach(function () {
    Mcp::web('/mcp/company', CompanyMcpServer::class);
    Mcp::web('/mcp/other', OtherMcpServer::class);
});

it('discovers registered web mcp servers and their tools', function () {
    $servers = app(McpDocumentationRepository::class)->servers();

    expect($servers)->toHaveCount(2)
        ->and($servers[0]['path'])->toBe('/mcp/company')
        ->and($servers[0]['anchor'])->toBe('server-mcp-company')
        ->and($servers[0]['class'])->toBe(CompanyMcpServer::class)
        ->and($servers[0]['name'])->toBe('Panda Pockets Company MCP Server')
        ->and($servers[0]['version'])->toBe('1.2.3')
        ->and($servers[0]['instructions'])->toBe('Use these tools to manage company data.')
        ->and($servers[0]['tools'])->toHaveCount(1)
        ->and($servers[0]['tools'][0]['name'])->toBe('find-employee')
        ->and($servers[0]['tools'][0]['anchor'])->toBe('tool-mcp-company-find-employee')
        ->and($servers[0]['tools'][0]['inputSchema']['properties']['email']['description'])->toBe('Employee email address')
        ->and($servers[1]['path'])->toBe('/mcp/other')
        ->and($servers[1]['anchor'])->toBe('server-mcp-other')
        ->and($servers[1]['name'])->toBe('Other MCP')
        ->and($servers[1]['tools'][0]['anchor'])->toBe('tool-mcp-other-ping-other')
        ->and($servers[1]['tools'][0]['name'])->toBe('ping-other');
});

it('filters servers by configured server class', function () {
    config()->set('mcp-documentation-generator.servers', [OtherMcpServer::class]);

    $servers = app(McpDocumentationRepository::class)->servers();

    expect($servers)->toHaveCount(1)
        ->and($servers[0]['class'])->toBe(OtherMcpServer::class);
});

it('does not require server context implementation metadata to be public', function () {
    Mcp::web('/mcp/legacy', LegacyContextMcpServer::class);

    config()->set('mcp-documentation-generator.servers', [LegacyContextMcpServer::class]);

    $servers = app(McpDocumentationRepository::class)->servers();

    expect($servers)->toHaveCount(1)
        ->and($servers[0]['name'])->toBe('Legacy Context MCP')
        ->and($servers[0]['version'])->toBe('2.0.0')
        ->and($servers[0]['instructions'])->toBe('Legacy context instructions.');
});

it('discovers servers using normal container construction', function () {
    Mcp::web('/mcp/constructor', ConstructorConfiguredMcpServer::class);

    config()->set('mcp-documentation-generator.servers', [ConstructorConfiguredMcpServer::class]);

    $servers = app(McpDocumentationRepository::class)->servers();

    expect($servers)->toHaveCount(1)
        ->and($servers[0]['name'])->toBe('Constructor MCP')
        ->and($servers[0]['tools'])->toHaveCount(1)
        ->and($servers[0]['tools'][0]['name'])->toBe('ping-other');
});

it('discovers tools registered while the server boots', function () {
    Mcp::web('/mcp/boot-configured', BootConfiguredMcpServer::class);

    config()->set('mcp-documentation-generator.servers', [BootConfiguredMcpServer::class]);

    $servers = app(McpDocumentationRepository::class)->servers();

    expect($servers)->toHaveCount(1)
        ->and($servers[0]['tools'])->toHaveCount(1)
        ->and($servers[0]['tools'][0]['name'])->toBe('ping-other');
});

it('keeps servers whose individual tools cannot be inspected', function () {
    Mcp::web('/mcp/broken', BrokenSchemaMcpServer::class);

    $servers = app(McpDocumentationRepository::class)->servers();

    expect($servers)->toHaveCount(3)
        ->and(array_column($servers, 'class'))->toContain(CompanyMcpServer::class, OtherMcpServer::class)
        ->and(array_column($servers, 'class'))->toContain(BrokenSchemaMcpServer::class)
        ->and($servers[2]['tools'])->toBe([]);
});

it('logs inspection failures for included servers only', function () {
    Mcp::web('/mcp/broken', BrokenSchemaMcpServer::class);
    Mcp::web('/mcp/excluded-broken', OtherBrokenSchemaMcpServer::class);

    config()->set('mcp-documentation-generator.servers', [
        CompanyMcpServer::class,
        BrokenSchemaMcpServer::class,
    ]);

    Log::shouldReceive('warning')
        ->once()
        ->with(
            'Unable to inspect MCP tool for documentation.',
            Mockery::on(fn (array $context): bool => $context['server'] === BrokenSchemaMcpServer::class
                && $context['route'] === 'mcp/broken'
                && $context['tool'] === 'broken-schema'
                && $context['exception'] instanceof Throwable),
        );

    $servers = app(McpDocumentationRepository::class)->servers();

    expect($servers)->toHaveCount(2)
        ->and($servers[0]['class'])->toBe(CompanyMcpServer::class)
        ->and($servers[1]['class'])->toBe(BrokenSchemaMcpServer::class)
        ->and($servers[1]['tools'])->toBe([]);
});
