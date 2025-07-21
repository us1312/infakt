<?php

use SCA\InFakt\Client\ApiClient;
use SCA\InFakt\Client\Authenticator;
use SCA\InFakt\Exception\RateLimitException;
use SCA\InFakt\Util\RateLimiter;

require_once __DIR__ . '/../vendor/autoload.php';
$apiKey = 'your-api-key-here';
$sandbox = true;

try {
    echo "=== InFakt API Client - Zaawansowane funkcje ===\n\n";
    echo "1. Konfiguracja z loggerem...\n";

    $logger = new \Psr\Log\NullLogger('infakt');

    echo "2. Konfiguracja rate limitera...\n";
    $rateLimiter = new RateLimiter(
        maxRequests: 50,    
        timeWindow: 3600,   
        minInterval: 2      
    );
    $authenticator = new Authenticator($apiKey);
    $apiClient = new ApiClient(
        authenticator: $authenticator,
        sandbox: $sandbox,
        rateLimiter: $rateLimiter,
        httpClient: null,
        logger: $logger
    );

    echo "Klient skonfigurowany z loggerem i rate limiterem\n\n";
    echo "3. Test rate limitingu...\n";
    for ($i = 1; $i <= 3; $i++) {
        try {
            echo "Request $i: ";
            $customers = $apiClient->customerModule->list([], 1, 1);
            echo "OK\n";
            $stats = $apiClient->getRateLimiter()->getStats();
            echo "  Pozostałe requesty: {$stats['remaining_requests']}\n";
        } catch (RateLimitException $e) {
            echo "Rate limit! Czekam {$e->getRetryAfter()} sekund...\n";
            sleep($e->getRetryAfter());
            $i--; 
        }
    }

    echo "\n4. Pobieranie wszystkich klientów (wszystkie strony)...\n";

    $allCustomers = $apiClient->customerModule->getAllCustomers();

    echo "Pobrano łącznie " . count($allCustomers) . " klientów ze wszystkich stron\n";
    echo "\n5. Zaawansowane filtrowanie faktur...\n";

    $invoices = $apiClient->vatInvoiceModule->findByDateRange(
        dateFrom: date('Y-m-01', strtotime('-1 month')), 
        dateTo: date('Y-m-t', strtotime('-1 month')),
        page: 1,
        limit: 50
    );

    echo "Faktury z poprzedniego miesiąca: " . count($invoices['entities'] ?? []) . "\n";
    echo "\n6. Demonstracja retry przy błędach...\n";
    $maxRetries = 3;
    $retryCount = 0;

    while ($retryCount < $maxRetries) {
        try {
            $invoice = $apiClient->vatInvoiceModule->read('999999');
            break; 
        } catch (\SCA\InFakt\Exception\ApiException $e) {
            $retryCount++;
            echo "Próba $retryCount nieudana: " . $e->getMessage() . "\n";
            if ($retryCount >= $maxRetries) {
                echo "Przekroczono maksymalną liczbę prób\n";
                break;
            }
            $waitTime = pow(2, $retryCount);
            echo "Czekam {$waitTime} sekund przed kolejną próbą...\n";
            sleep($waitTime);
        }
    }

    echo "\n7. Walidacja danych przed wysłaniem...\n";
    $customer = new \SCA\InFakt\Model\CustomerModel();
    $customer->companyName = 'Test Company';
    $customer->country = 'INVALID'; 
    $customer->email = 'invalid-email'; 
    $customer->nip = '123'; 
    $errors = $customer->validate();
    if (!empty($errors)) {
        echo "Znalezione błędy walidacji:\n";
        foreach ($errors as $field => $error) {
            echo "  {$field}: {$error}\n";
        }
    }
    echo "\n8. Monitoring wydajności...\n";
    $startTime = microtime(true);
    $customers = $apiClient->customerModule->list([], 1, 10);
    $endTime = microtime(true);
    $duration = ($endTime - $startTime) * 1000; 
    echo "Czas wykonania requestu: " . round($duration, 2) . " ms\n";
    echo "\n9. Końcowy stan rate limitera:\n";
    $finalStats = $apiClient->getRateLimiter()->getStats();
    echo "Wykonane requesty: {$finalStats['current_requests']}\n";
    echo "Pozostałe requesty: {$finalStats['remaining_requests']}\n";
    echo "Reset za: " . ($finalStats['reset_time'] - time()) . " sekund\n";
} catch (Exception $e) {
    echo "Błąd: " . $e->getMessage() . "\n";
    echo "Typ: " . get_class($e) . "\n";
}
echo "\n=== Koniec przykładu zaawansowanego ===\n";
