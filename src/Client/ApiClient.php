<?php

namespace SCA\InFakt\Client;

use SCA\InFakt\Client\Modules\OssInvoiceModule;
use SCA\InFakt\Client\Modules\VatInvoiceModule;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiClient
{
    public VatInvoiceModule $vatInvoiceModule;
    public OssInvoiceModule $ossInvoiceModule;
    private HttpClientInterface $httpClient;

    public function __construct(
        private Authenticator       $authenticator,
        private bool                $sandbox = false,
        ?HttpClientInterface $httpClient = NULL,
    ) {
        $this->httpClient = $httpClient ?? HttpClient::create();
        $this->baseUri = $this->sandbox
            ? rtrim('https://api.sandbox-infakt.pl/v3', '/')
            : rtrim('https://api.infakt.pl/v3', '/');

        $this->vatInvoiceModule = new VatInvoiceModule($this);
        $this->ossInvoiceModule = new OssInvoiceModule($this);
    }

    public function request(string $method, string $endpoint, array $options = []): array {
        $options['headers'] = array_merge(
            $options['headers'] ?? [],
            $this->authenticator->getHeaders()
        );

        $url = $this->baseUri . '/' . ltrim($endpoint, '/');
        $response = $this->httpClient->request($method, $url, $options);

        if ($response->getStatusCode() >= 400) {
            throw new \Exception('API request failed: ' . $response->getContent(false));
        }

        return $response->toArray();
    }
}