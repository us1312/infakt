<?php

namespace SCA\InFakt\Client;

use SCA\InFakt\Client\Modules\CustomerModule;
use SCA\InFakt\Client\Modules\OssInvoiceModule;
use SCA\InFakt\Client\Modules\OssTaxRates;
use SCA\InFakt\Client\Modules\VatInvoiceModule;
use SCA\InFakt\Exception\ApiException;
use SCA\InFakt\Exception\AuthenticationException;
use SCA\InFakt\Exception\RateLimitException;
use SCA\InFakt\Util\RateLimiter;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;

class ApiClient
{
    public VatInvoiceModule $vatInvoiceModule;
    public OssInvoiceModule $ossInvoiceModule;
    public OssTaxRates $ossTaxRates;
    public CustomerModule $customerModule;
    private HttpClientInterface $httpClient;
    private string $baseUri;
    private ?LoggerInterface $logger;
    private RateLimiter $rateLimiter;
    private array $rateLimitState = [];

    public function __construct(
        private Authenticator $authenticator,
        private bool $sandbox = false,
        ?RateLimiter $rateLimiter = null,
        ?HttpClientInterface $httpClient = null,
        ?LoggerInterface $logger = null
    ) {
        $this->httpClient = $httpClient ?? HttpClient::create();
        $this->logger = $logger;
        $this->rateLimiter = $rateLimiter ?? new RateLimiter();
        $this->baseUri = $this->sandbox
            ? rtrim('https://api.sandbox-infakt.pl/v3', '/')
            : rtrim('https://api.infakt.pl/v3', '/');

        $this->vatInvoiceModule = new VatInvoiceModule($this);
        $this->ossInvoiceModule = new OssInvoiceModule($this);
        $this->ossTaxRates = new OssTaxRates($this);
        $this->customerModule = new CustomerModule($this);
    }

    public function request(string $method, string $endpoint, array $options = []): array|string
    {
        $this->checkRateLimit();

        $options['headers'] = array_merge(
            $options['headers'] ?? [],
            $this->authenticator->getHeaders()
        );

        $url = $this->baseUri . '/' . ltrim($endpoint, '/');
        
        $this->log('debug', 'Making API request', [
            'method' => $method,
            'url' => $url,
            'options' => $options
        ]);

        try {
            $response = $this->httpClient->request($method, $url, $options);
            $statusCode = $response->getStatusCode();
            
            $this->updateRateLimitState($response);

            if ($statusCode >= 400) {
                $this->handleErrorResponse($response, $statusCode);
            }

            $contentType = $response->getHeaders(false)['content-type'][0] ?? '';
            $content = str_contains($contentType, 'application/json') 
                ? $response->toArray() 
                : $response->getContent();

            $this->log('debug', 'API request successful', [
                'status_code' => $statusCode,
                'content_type' => $contentType
            ]);

            return $content;

        } catch (HttpExceptionInterface $e) {
            $this->log('error', 'HTTP exception during API request', [
                'exception' => $e->getMessage(),
                'url' => $url
            ]);
            throw new ApiException('HTTP request failed: ' . $e->getMessage(), $e->getResponse()->getStatusCode());
        }
    }

    private function checkRateLimit(): void
    {
        // Sprawdź lokalny rate limiter
        $this->rateLimiter->checkLimit();
        
        // Sprawdź stan z serwera (jeśli dostępny)
        if (isset($this->rateLimitState['retry_after']) && 
            time() < $this->rateLimitState['retry_after']) {
            $waitTime = $this->rateLimitState['retry_after'] - time();
            throw new RateLimitException($waitTime);
        }
        
        // Zapisz request w lokalnym limiterze
        $this->rateLimiter->recordRequest();
    }

    private function updateRateLimitState($response): void
    {
        $headers = $response->getHeaders(false);
        
        if (isset($headers['x-ratelimit-remaining'])) {
            $this->rateLimitState['remaining'] = (int)$headers['x-ratelimit-remaining'][0];
        }
        
        if (isset($headers['x-ratelimit-reset'])) {
            $this->rateLimitState['reset'] = (int)$headers['x-ratelimit-reset'][0];
        }
    }

    private function handleErrorResponse($response, int $statusCode): void
    {
        $content = $response->getContent(false);
        $data = [];
        
        if (json_validate($content)) {
            $data = json_decode($content, true);
        }

        $message = $data['message'] ?? $data['error'] ?? 'API request failed';

        $this->log('error', 'API error response', [
            'status_code' => $statusCode,
            'response_data' => $data
        ]);

        switch ($statusCode) {
            case 401:
                throw new AuthenticationException($message);
            case 429:
                $retryAfter = $response->getHeaders(false)['retry-after'][0] ?? 60;
                $this->rateLimitState['retry_after'] = time() + (int)$retryAfter;
                throw new RateLimitException((int)$retryAfter, $message);
            default:
                throw new ApiException($message, $statusCode, $data);
        }
    }

    private function log(string $level, string $message, array $context = []): void
    {
        if ($this->logger) {
            $this->logger->log($level, $message, $context);
        }
    }

    public function getRateLimitState(): array
    {
        $serverState = $this->rateLimitState;
        $localState = $this->rateLimiter->getStats();
        
        return array_merge($serverState, [
            'local_limiter' => $localState
        ]);
    }

    public function getRateLimiter(): RateLimiter
    {
        return $this->rateLimiter;
    }
}
