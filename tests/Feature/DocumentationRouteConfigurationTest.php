<?php

use Sezy\LaravelMcpDocumentationGenerator\Tests\Fixtures\AddDocsHeaderMiddleware;

it('uses the configured url and middleware', function () {
    $this->reloadDocumentationRoutesWithConfig([
        'enabled' => true,
        'url' => '/internal/mcp-docs',
        'middleware' => [AddDocsHeaderMiddleware::class],
    ]);

    $this->get('/internal/mcp-docs')
        ->assertOk()
        ->assertHeader('X-Mcp-Docs', 'configured');
});
