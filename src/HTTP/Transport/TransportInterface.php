<?php

namespace Islambey\Xapiand\HTTP\Transport;

interface TransportInterface
{
    public function sendRequest(
        string $method,
        string $uri,
        array $headers = null,
        string $body = null
    ): array;
}
