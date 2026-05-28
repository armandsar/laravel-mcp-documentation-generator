<?php

namespace Sezy\LaravelMcpDocumentationGenerator\Support;

class SchemaDocumentation
{
    /**
     * @param  array<string, mixed>  $schema
     * @return array<int, array{name: string, type: string, description: string, required: bool}>
     */
    public static function fields(array $schema): array
    {
        $properties = self::stringKeyedArray($schema['properties'] ?? null);

        if ($properties === null) {
            return [];
        }

        $required = self::strings($schema['required'] ?? []);

        $fields = [];

        foreach ($properties as $name => $propertyValue) {
            $property = self::stringKeyedArray($propertyValue);

            if ($property === null) {
                continue;
            }

            $fields[] = [
                'name' => $name,
                'type' => self::type($property),
                'description' => is_string($property['description'] ?? null) ? $property['description'] : '',
                'required' => in_array($name, $required, true),
            ];
        }

        return $fields;
    }

    /**
     * @param  array<string, mixed>  $property
     */
    protected static function type(array $property): string
    {
        if (isset($property['enum']) && is_array($property['enum'])) {
            return implode(' | ', array_map(
                fn (mixed $value): string => json_encode($value, JSON_UNESCAPED_SLASHES) ?: '',
                $property['enum'],
            ));
        }

        $type = $property['type'] ?? 'mixed';

        if (is_array($type)) {
            $types = self::strings($type);

            if ($types !== []) {
                return implode(' | ', $types);
            }
        }

        if ($type === 'array') {
            $items = self::stringKeyedArray($property['items'] ?? null);

            if ($items === null) {
                return 'array';
            }

            $itemType = self::type($items);

            if (str_contains($itemType, ' | ')) {
                $itemType = '('.$itemType.')';
            }

            return $itemType.'[]';
        }

        return is_string($type) ? $type : 'mixed';
    }

    /**
     * @return array<string, mixed>|null
     */
    protected static function stringKeyedArray(mixed $value): ?array
    {
        if (! is_array($value)) {
            return null;
        }

        return array_filter($value, function ($key) {
            return is_string($key);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * @return array<int, string>
     */
    protected static function strings(mixed $value): array
    {
        if (! is_array($value)) {
            return [];
        }

        return array_values(array_filter($value, is_string(...)));
    }
}
