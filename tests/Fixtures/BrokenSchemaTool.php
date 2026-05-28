<?php

namespace Sezy\LaravelMcpDocumentationGenerator\Tests\Fixtures;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Server\Tool;
use RuntimeException;

class BrokenSchemaTool extends Tool
{
    protected string $name = 'broken-schema';

    /**
     * @return array<string, mixed>
     */
    public function schema(JsonSchema $schema): array
    {
        throw new RuntimeException('Schema cannot be inspected.');
    }
}
