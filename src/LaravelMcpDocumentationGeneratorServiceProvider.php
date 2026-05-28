<?php

namespace Sezy\LaravelMcpDocumentationGenerator;

use Sezy\LaravelMcpDocumentationGenerator\Commands\LaravelMcpDocumentationGeneratorCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelMcpDocumentationGeneratorServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-mcp-documentation-generator')
            ->hasConfigFile()
            ->hasViews()
            ->hasRoute('web');
    }
}
