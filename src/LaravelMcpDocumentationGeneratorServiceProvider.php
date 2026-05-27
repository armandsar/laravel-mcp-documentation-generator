<?php

namespace Sezy\LaravelMcpDocumentationGenerator;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Sezy\LaravelMcpDocumentationGenerator\Commands\LaravelMcpDocumentationGeneratorCommand;

class LaravelMcpDocumentationGeneratorServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-mcp-documentation-generator')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_mcp_documentation_generator_table')
            ->hasCommand(LaravelMcpDocumentationGeneratorCommand::class);
    }
}
