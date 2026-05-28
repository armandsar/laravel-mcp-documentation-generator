<?php

namespace Sezy\LaravelMcpDocumentationGenerator\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Sezy\LaravelMcpDocumentationGenerator\Discovery\McpDocumentationRepository;

class McpDocumentationController
{
    public function __invoke(McpDocumentationRepository $repository, Factory $views): View
    {
        return $views->make('mcp-documentation-generator::index', [
            'servers' => $repository->servers(),
        ]);
    }
}
