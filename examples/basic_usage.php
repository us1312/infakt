<?php

use SCA\InFakt\Client\ApiClient;
use SCA\InFakt\Client\Authenticator;
use SCA\InFakt\Infakt;

require_once __DIR__ . '/../vendor/autoload.php';

$apiKey = 'your-api-key-here';
$sandbox = true;

try {
    $authenticator = new Authenticator($apiKey);
    $apiClient = new ApiClient($authenticator, $sandbox);
    $infakt = new Infakt($apiClient);

    echo "=== InFakt API Client - Podstawowe użycie ===\n\n";
    echo "1. Sprawdzanie szczegółów konta...\n";

    $accountDetails = $infakt->getAccountDetails();

    echo "Konto: " . ($accountDetails['company_name'] ?? 'Nieznane') . "\n\n";
    echo "2. Tworzenie nowego klienta...\n";

    $customer = new CustomerModel();
    $customer->companyName = 'Przykładowa Firma Sp. z o.o.';
    $customer->street = 'ul. Testowa 123';
    $customer->city = 'Warszawa';
    $customer->postalCode = '00-001';
    $customer->country = 'PL';
    $customer->nip = '1234567890';
    $customer->email = 'kontakt@przyklad.pl';

    $errors = $customer->validate();
    if (!empty($errors)) {
        echo "Błędy walidacji klienta:\n";
        print_r($errors);
    } else {
        $customerData = ['client' => $customer->getAll($customer)];
        $createdCustomer = $apiClient->customerModule->create($customerData);

        echo "Utworzono klienta o ID: " . $createdCustomer['id'] . "\n";
    }

    echo "\n3. Pobieranie listy klientów...\n";

    $customers = $apiClient->customerModule->list([], 1, 5);

    echo "Znaleziono " . count($customers['entities'] ?? []) . " klientów\n";

    if (isset($customers['pagination'])) {
        $pagination = $customers['pagination'];
        echo "Strona: {$pagination['current_page']}/{$pagination['total_pages']}\n";
        echo "Łącznie elementów: {$pagination['total_items']}\n";
    }

    echo "\n4. Wyszukiwanie klientów...\n";
    $searchResults = $apiClient->customerModule->search(['name' => ['modifier' => 'eq', 'value' => 'Przykładowa']]);
    echo "Znaleziono " . count($searchResults['entities'] ?? []) . " klientów pasujących do zapytania\n";
    echo "\n5. Tworzenie faktury VAT...\n";

    if (!empty($createdCustomer['id'])) {
        $invoiceData = [
            'invoice' => [
                'client_id' => $createdCustomer['id'],
                'invoice_date' => date('Y-m-d'),
                'sale_date' => date('Y-m-d'),
                'payment_method' => 'transfer',
                'payment_date' => date('Y-m-d', strtotime('+14 days')),
                'services' => [
                    [
                        'name' => 'Usługa programistyczna',
                        'tax_symbol' => 'vat_23',
                        'unit_net_price' => 10000, 
                        'quantity' => 1
                    ]
                ]
            ]
        ];
        $invoice = $apiClient->vatInvoiceModule->create($invoiceData);
        echo "Utworzono fakturę o ID: " . $invoice['id'] . "\n";
        $status = $apiClient->vatInvoiceModule->checkStatus($invoice['id']);
        echo "Status faktury: " . ($status['status'] ?? 'nieznany') . "\n";
    }

    echo "\n6. Pobieranie listy faktur...\n";

    $invoices = $apiClient->vatInvoiceModule->list([
        'invoice_date_from' => date('Y-m-01'), 
        'invoice_date_to' => date('Y-m-d')     
    ], 1, 10);

    echo "Znaleziono " . count($invoices['entities'] ?? []) . " faktur w tym miesiącu\n";
    echo "\n7. Stan limitów API:\n";

    $rateLimitState = $apiClient->getRateLimitState();

    if (isset($rateLimitState['local_limiter'])) {
        $localLimiter = $rateLimitState['local_limiter'];
        echo "Pozostałe requesty: " . $localLimiter['remaining_requests'] . "\n";
        echo "Reset za: " . ($localLimiter['reset_time'] - time()) . " sekund\n";
    }
} catch (ValidationException $e) {
    echo "Błąd walidacji: " . $e->getMessage() . "\n";
    echo "Szczegóły błędów:\n";
    print_r($e->getErrors());
} catch (ApiException $e) {
    echo "Błąd API: " . $e->getMessage() . "\n";
    echo "Status code: " . $e->getStatusCode() . "\n";
    if (!empty($e->getResponseData())) {
        echo "Dane odpowiedzi:\n";
        print_r($e->getResponseData());
    }
} catch (Exception $e) {
    echo "Nieoczekiwany błąd: " . $e->getMessage() . "\n";
}
echo "\n=== Koniec przykładu ===\n";
