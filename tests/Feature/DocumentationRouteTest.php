<?php

use Illuminate\Support\Facades\Route;

it('publishes opt-in documentation config by default', function () {
    $config = require __DIR__.'/../../config/mcp-documentation-generator.php';

    expect($config)->toMatchArray([
        'enabled' => false,
        'url' => '/docs/mcp',
        'middleware' => [],
        'servers' => [],
    ]);
});

it('registers the documentation route at the configured url', function () {
    expect(Route::has('mcp-documentation-generator.index'))->toBeTrue();

    $this->get('/docs/mcp')->assertOk();
});
