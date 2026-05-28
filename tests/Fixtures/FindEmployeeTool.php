<?php

namespace Sezy\LaravelMcpDocumentationGenerator\Tests\Fixtures;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Server\Tool;

class FindEmployeeTool extends Tool
{
    protected string $name = 'find-employee';

    protected string $title = 'Find employee';

    protected string $description = 'Find an employee by email address.';

    /**
     * @return array<string, mixed>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'email' => $schema->string()->description('Employee email address')->required(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function outputSchema(JsonSchema $schema): array
    {
        return [
            'employee_id' => $schema->string()->description('Employee identifier')->required(),
        ];
    }
}
