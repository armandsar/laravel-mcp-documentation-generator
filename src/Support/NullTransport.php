<?php

namespace Sezy\LaravelMcpDocumentationGenerator\Support;

use Closure;
use Laravel\Mcp\Server\Contracts\Transport;

class NullTransport implements Transport
{
    public function onReceive(Closure $handler): void
    {
        //
    }

    public function run(): null
    {
        return null;
    }

    public function send(string $message, ?string $sessionId = null): void
    {
        //
    }

    public function sessionId(): ?string
    {
        return null;
    }

    public function stream(Closure $stream): void
    {
        $stream();
    }
}
