<?php

namespace Sezy\LaravelMcpDocumentationGenerator\Commands;

use Illuminate\Console\Command;

class LaravelMcpDocumentationGeneratorCommand extends Command
{
    public $signature = 'laravel-mcp-documentation-generator';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
