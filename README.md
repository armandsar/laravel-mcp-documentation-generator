# Laravel MCP Documentation Generator (BETA)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/armandsar/laravel-mcp-documentation-generator.svg?style=flat-square)](https://packagist.org/packages/armandsar/laravel-mcp-documentation-generator)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/armandsar/laravel-mcp-documentation-generator/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/armandsar/laravel-mcp-documentation-generator/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/armandsar/laravel-mcp-documentation-generator/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/armandsar/laravel-mcp-documentation-generator/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)

Generate HTML documentation for Laravel MCP servers.

## Installation

You can install the package via composer:

```bash
composer require armandsar/laravel-mcp-documentation-generator
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="mcp-documentation-generator-config"
```

Contents of the published config file:

```php
return [
    'enabled' => env('MCP_DOCS_ENABLED', false),

    'url' => '/docs/mcp',

    'middleware' => [],

    'servers' => [],
];
```

## Usage

Register one or more Laravel MCP web servers in your application:

```php
use App\Mcp\CompanyMcpServer;
use App\Mcp\OtherMcpServer;
use Laravel\Mcp\Facades\Mcp;

Mcp::web('/mcp/company', CompanyMcpServer::class);
Mcp::web('/mcp/other', OtherMcpServer::class);
```

Enable the route and open `/docs/mcp`:

```dotenv
MCP_DOCS_ENABLED=true
```

The readable schema tables cover the common top-level fields, required flags, enums, arrays, and simple union types. The full raw JSON schemas are always available beside the readable tables for nested or advanced schema shapes.

To restrict the docs page to specific servers, configure `servers` with server classes. Leave it empty to include every discovered web MCP server:

```php
'servers' => [
    CompanyMcpServer::class,
],
```

Keep the route disabled in environments where it should not be public, or add middleware to protect it:

```php
'middleware' => ['auth'],
```

## Testing

```bash
composer test
```

## Credits

- [Armands Leinieks](https://github.com/armandsar)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
