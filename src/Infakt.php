<?php
namespace SCA\InFakt;
use SCA\InFakt\Client\ApiClient;
class Infakt
{
    public function __construct(private ApiClient $apiClient) {
    }

    public function getClient(): ApiClient {
        return $this->apiClient;
    }
    
    public function getAccountDetails(): array {
        return $this->apiClient->request('GET', 'account');
    }
}