<?php

namespace Sezy\LaravelMcpDocumentationGenerator\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Sezy\LaravelMcpDocumentationGenerator\LaravelMcpDocumentationGenerator
 */
class LaravelMcpDocumentationGenerator extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Sezy\LaravelMcpDocumentationGenerator\LaravelMcpDocumentationGenerator::class;
    }
}
