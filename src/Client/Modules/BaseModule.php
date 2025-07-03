<?php

namespace SCA\InFakt\Client\Modules;

use SCA\InFakt\Client\ApiClient;

abstract class BaseModule
{
    public function __construct(protected ApiClient $client) {
    }

    protected function request(string $method, string $endpoint, array $options = []): array | string{
        return $this->client->request($method, $endpoint, $options);
    }
}