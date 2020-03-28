<?php
declare(strict_types=1);

namespace Islambey\Xapiand;

use InvalidArgumentException;
use Islambey\Xapiand\HTTP\Transport\DefaultTransport;
use Islambey\Xapiand\HTTP\Transport\TransportInterface;
use Exception;
use function filter_var;
use function json_decode;
use function json_encode;
use function rtrim;

class Xapiand
{
    private string $uri;
    private TransportInterface $transport;
    private Index $index;
    private Document $document;

    public function __construct(string $uri, TransportInterface $transport = null)
    {
        if (!filter_var($uri, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Uri not valid.');
        }

        $this->uri = rtrim($uri, '/');
        $this->transport = $transport ?? new DefaultTransport($this->uri);
    }

    public function index()
    {
        $this->index ??= new Index($this->transport);

        return $this->index;
    }

    public function document()
    {
        $this->document ??= new Document($this->transport);

        return $this->document;
    }

    public function search(string $index, array $query): array
    {
        if (empty($index)) {
            throw new Exception('Index can not be empty.');
        }

        $uri = $index . '/';
        [$httpCode, $response] = $this->transport->sendRequest(
            "SEARCH",
            $uri,
            null,
            json_encode($query)
        );

        $body = json_decode($response, true);

        if ($httpCode !== 200) {
            throw new Exception($body->message ?? "Unexpected error.");
        }

        return $body;
    }

    public function getServerInfo(): array
    {
        [, $response] = $this->transport->sendRequest("GET", "/");

        return json_decode($response, true);
    }
}