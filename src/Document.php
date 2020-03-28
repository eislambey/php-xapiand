<?php
declare(strict_types=1);

namespace Islambey\Xapiand;

use Islambey\Xapiand\HTTP\Transport\TransportInterface;
use Exception;

class Document
{
    private $transport;

    /**
     * Document constructor.
     * @param TransportInterface $transport
     */
    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    # index a document
    public function index(string $index, string $id, array $document)
    {
        if (empty($index)) {
            throw new \InvalidArgumentException('Index can not be empty.');
        }
        $url = "$index/$id";
        [$httpCode, $response] = $this->transport->sendRequest(
            'PUT',
            $url,
            null,
            \json_encode($document)
        );
        if (204 !== $httpCode) {
            $body = \json_decode($response);
            if (isset($body->message)) {
                throw new \Exception($body->message);
            } else {
                throw new \RuntimeException('Unexpected error.');
            }
        }

        return true;
    }

    public function get(string $index, string $id): array
    {
        $uri = "$index/$id";
        [$httpCode, $response] = $this->transport->sendRequest("GET", $uri);
        if (404 === $httpCode) {
            throw new NotFoundException("Document ($index/$id) not found");
        }

        return \json_decode($response, true);
    }

    public function exists(string $index, string $id): bool
    {
        $uri = "$index/$id";
        [$httpCode,] = $this->transport->sendRequest("HEAD", $uri);
        return 200 === $httpCode;
    }

    public function update(string $index, string $id, array $document): bool
    {
        if (empty($index)) {
            throw new \InvalidArgumentException("Index can not be empty.");
        }
        $url = "$index/$id";
        [$httpCode, $response] = $this->transport->sendRequest("UPDATE", $url, null, json_encode($document));
        if (204 !== $httpCode) {
            $body = \json_decode($response);
            if (isset($body->message)) {
                throw new Exception($body->message);
            } else {
                throw new Exception("Unexpected error.");
            }
        }

        return true;
    }

    public function info(string $index, string $id): array
    {
        $uri = "$index/$id";
        [$httpCode, $response] = $this->transport->sendRequest("INFO", $uri);

        if (404 === $httpCode) {
            throw new NotFoundException("Document ($index/$id) not found");
        }

        return \json_decode(
            \mb_convert_encoding($response, "UTF-8", "UTF-8"),
            true
        );
    }

    public function delete(string $index, string $id): bool
    {
        $url = "$index/$id";

        [$httpCode,] = $this->transport->sendRequest("DELETE", $url);

        if (404 === $httpCode) {
            throw new NotFoundException("Document ($index/$id) not found");
        }

        return true;
    }

    public function store()
    {
        // TODO:
        throw new \RuntimeException("Not implemented yet.");
    }

    public function script()
    {
        // TODO:
        throw new \RuntimeException("Not implemented yet.");
    }
}