<?php

namespace Islambey\Xapiand\HTTP\Response;

final class SearchResponse
{
    private array $rawResponse;

    public function __construct(array $rawResponse)
    {
        $this->rawResponse = $rawResponse;
    }

    public function getRawResponse(): array
    {
        return $this->rawResponse;
    }

    public function count(): int
    {
        return $this->rawResponse["count"];
    }

    public function total(): int
    {
        return $this->rawResponse["total"];
    }

    public function took(): int
    {
        return $this->rawResponse["took"];
    }

    public function hits(): array
    {
        return $this->rawResponse["hits"];
    }
}