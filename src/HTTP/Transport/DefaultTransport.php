<?php
declare(strict_types=1);

namespace Islambey\Xapiand\HTTP\Transport;

use Exception;
use function curl_close;
use function curl_error;
use function curl_exec;
use function curl_getinfo;
use function curl_init;
use function curl_setopt;
use function curl_setopt_array;
use function rtrim;

class DefaultTransport implements TransportInterface
{
    private const OP_CONNECTTIMEOUT = 5;

    private string $uri;

    public function __construct(string $uri)
    {
        $this->uri = rtrim($uri, "/") . "/";
    }

    public function sendRequest(
        string $method,
        string $uri,
        array $headers = null,
        string $body = null
    ): array
    {
        $ch = curl_init($this->uri . $uri);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
            CURLOPT_CONNECTTIMEOUT => self::OP_CONNECTTIMEOUT,
        ]);

        if ($body) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($error = curl_error($ch)) {
            throw new Exception($error);
        }
        curl_close($ch);

        return [$httpCode, $response];
    }
}
