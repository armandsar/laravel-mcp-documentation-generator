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

it('documents nested array object fields with path notation', function () {
    $fields = SchemaDocumentation::fields([
        'type' => 'object',
        'required' => ['shifts'],
        'properties' => [
            'shifts' => [
                'type' => 'array',
                'description' => 'Main schedule shifts in the requested date range.',
                'items' => [
                    'type' => 'object',
                    'required' => ['id', 'name'],
                    'properties' => [
                        'id' => [
                            'type' => 'string',
                            'description' => 'Shift UUID.',
                        ],
                        'name' => [
                            'type' => ['string', 'null'],
                            'description' => 'Shift name.',
                        ],
                    ],
                ],
            ],
        ],
    ]);

    expect($fields)->toBe([
        [
            'name' => 'shifts',
            'type' => 'object[]',
            'description' => 'Main schedule shifts in the requested date range.',
            'required' => true,
        ],
        [
            'name' => 'shifts[].id',
            'type' => 'string',
            'description' => 'Shift UUID.',
            'required' => true,
        ],
        [
            'name' => 'shifts[].name',
            'type' => 'string | null',
            'description' => 'Shift name.',
            'required' => true,
        ],
    ]);
});

it('documents deeply nested object array fields', function () {
    $fields = SchemaDocumentation::fields([
        'type' => 'object',
        'properties' => [
            'shifts' => [
                'type' => 'array',
                'items' => [
                    'type' => 'object',
                    'properties' => [
                        'segments' => [
                            'type' => 'array',
                            'items' => [
                                'type' => 'object',
                                'properties' => [
                                    'breaks' => [
                                        'type' => 'array',
                                        'items' => [
                                            'type' => 'object',
                                            'required' => ['start'],
                                            'properties' => [
                                                'start' => [
                                                    'type' => 'string',
                                                    'description' => 'Break start time.',
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ]);

    expect(array_column($fields, 'type', 'name'))->toBe([
        'shifts' => 'object[]',
        'shifts[].segments' => 'object[]',
        'shifts[].segments[].breaks' => 'object[]',
        'shifts[].segments[].breaks[].start' => 'string',
    ]);

    expect($fields[3])->toMatchArray([
        'name' => 'shifts[].segments[].breaks[].start',
        'description' => 'Break start time.',
        'required' => true,
    ]);
});

it('documents nested array item fields beyond one array level', function () {
    $fields = SchemaDocumentation::fields([
        'type' => 'object',
        'properties' => [
            'weekly_shifts' => [
                'type' => 'array',
                'items' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'required' => ['id'],
                        'properties' => [
                            'id' => [
                                'type' => 'string',
                                'description' => 'Shift UUID.',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ]);

    expect($fields)->toBe([
        [
            'name' => 'weekly_shifts',
            'type' => 'object[][]',
            'description' => '',
            'required' => false,
        ],
        [
            'name' => 'weekly_shifts[][].id',
            'type' => 'string',
            'description' => 'Shift UUID.',
            'required' => true,
        ],
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
