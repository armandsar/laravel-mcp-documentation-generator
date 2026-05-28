<?php

namespace Sezy\LaravelMcpDocumentationGenerator\Tests\Fixtures;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddDocsHeaderMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Mcp-Docs', 'configured');

        return $response;
    }
}
