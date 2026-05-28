<?php

use Illuminate\Support\Facades\Route;

it('does not register the documentation route when disabled', function () {
    $this->reloadDocumentationRoutesWithConfig([
        'enabled' => false,
    ]);

    expect(Route::has('mcp-documentation-generator.index'))->toBeFalse();

    $this->get('/docs/mcp')->assertNotFound();
});
