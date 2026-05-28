<?php

use Illuminate\Support\Facades\Route;
use Sezy\LaravelMcpDocumentationGenerator\Http\Controllers\McpDocumentationController;

if (config('mcp-documentation-generator.enabled')) {
    $middleware = config('mcp-documentation-generator.middleware', []);
    $url = config('mcp-documentation-generator.url', '/docs/mcp');

    if (! is_array($middleware) && ! is_string($middleware) && $middleware !== null) {
        $middleware = [];
    }

    if (! is_string($url) || $url === '') {
        $url = '/docs/mcp';
    }

    Route::middleware($middleware)
        ->get($url, McpDocumentationController::class)
        ->name('mcp-documentation-generator.index');
}
