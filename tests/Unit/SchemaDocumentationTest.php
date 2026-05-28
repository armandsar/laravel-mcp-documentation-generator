<?php

use Sezy\LaravelMcpDocumentationGenerator\Support\SchemaDocumentation;

it('documents schema fields with required flags', function () {
    $fields = SchemaDocumentation::fields([
        'type' => 'object',
        'required' => ['email'],
        'properties' => [
            'email' => [
                'type' => 'string',
                'description' => 'Employee email address',
            ],
            'limit' => [
                'type' => 'integer',
            ],
        ],
    ]);

    expect($fields)->toBe([
        [
            'name' => 'email',
            'type' => 'string',
            'description' => 'Employee email address',
            'required' => true,
        ],
        [
            'name' => 'limit',
            'type' => 'integer',
            'description' => '',
            'required' => false,
        ],
    ]);
});

it('documents enum and array field types', function () {
    $fields = SchemaDocumentation::fields([
        'type' => 'object',
        'properties' => [
            'status' => [
                'enum' => ['active', 'disabled'],
            ],
            'ids' => [
                'type' => 'array',
                'items' => [
                    'type' => 'string',
                ],
            ],
            'modes' => [
                'type' => 'array',
                'items' => [
                    'enum' => ['read', 'write'],
                ],
            ],
        ],
    ]);

    expect(array_column($fields, 'type', 'name'))->toBe([
        'status' => '"active" | "disabled"',
        'ids' => 'string[]',
        'modes' => '("read" | "write")[]',
    ]);
});

it('documents union field types', function () {
    $fields = SchemaDocumentation::fields([
        'type' => 'object',
        'properties' => [
            'external_id' => [
                'type' => ['string', 'null'],
            ],
        ],
    ]);

    expect($fields[0]['type'])->toBe('string | null');
});

it('ignores malformed schema properties', function () {
    $fields = SchemaDocumentation::fields([
        'type' => 'object',
        'properties' => [
            'valid' => [
                'type' => 'boolean',
            ],
            'invalid' => 'string',
        ],
        'required' => 'valid',
    ]);

    expect($fields)->toBe([
        [
            'name' => 'valid',
            'type' => 'boolean',
            'description' => '',
            'required' => false,
        ],
    ]);
});
