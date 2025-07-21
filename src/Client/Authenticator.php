<?php
namespace SCA\InFakt\Client;
class Authenticator
{
    public function __construct(private string $apiKey) {
    }
    public function getHeaders(): array {
        return [
            'X-inFakt-ApiKey' => $this->apiKey,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
}