<?php

namespace Sezy\LaravelMcpDocumentationGenerator\Support;

class Json
{
    public static function pretty(mixed $value): string
    {
        return json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) ?: '';
    }
}
