<?php
declare(strict_types=1);

namespace Islambey\Xapiand;

use Islambey\Xapiand\HTTP\Transport\TransportInterface;

class Index
{
    /**
     * @var TransportInterface
     */
    private $transport;

    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    public function create()
    {

    }

    public function exists(string $index): bool
    {
        $uri = "$index/";
        [$httpCode,] = $this->transport->sendRequest('HEAD', $uri);
        return 200 === $httpCode;
    }

    public function get()
    {

    }

    public function info(string $index): object
    {
        $uri = "$index/";
        [$httpCode, $response] = $this->transport->sendRequest('INFO', $uri);
        if ($httpCode === 404) {
            throw new NotFoundException("Index ($index) not found");
        }

        return \json_decode($response);
    }

    public function dump()
    {

    }

    public function restore()
    {

    }
}