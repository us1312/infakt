<?php

namespace SCA\InFakt\Client;

use SCA\InFakt\Client\Modules\InvoiceOss;
use SCA\InFakt\Client\Modules\InvoiceVat;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiClient
{
    public InvoiceVat $invoiceVat;
    public InvoiceOss $invoiceOss;

    public function __construct(
        private Authenticator       $authenticator,
        private HttpClientInterface $httpClient,
        private string              $baseUri = 'https://api.infakt.pl/v3'
    ) {
        $this->baseUri = rtrim($this->baseUri, '/');

        $this->invoiceVat = new InvoiceVat($this);
        $this->invoiceOss = new InvoiceOss($this);
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