<?php

require_once __DIR__ . '/../vendor/autoload.php';

use SCA\InFakt\Infakt;
use SCA\InFakt\Client\ApiClient;
use SCA\InFakt\Client\Authenticator;
use SCA\InFakt\Model\CustomerModel;
use SCA\InFakt\Model\VatInvoiceModel;
use SCA\InFakt\Exception\ApiException;
use SCA\InFakt\Exception\ValidationException;

// Konfiguracja
$apiKey = 'your-api-key-here';
$sandbox = true; // true dla testów, false dla produkcji

try {
    // Inicjalizacja klienta
    $authenticator = new Authenticator($apiKey);
    $apiClient = new ApiClient($authenticator, $sandbox);
    $infakt = new Infakt($apiClient);

    echo "=== InFakt API Client - Podstawowe użycie ===\n\n";

    // 1. Sprawdzenie szczegółów konta
    echo "1. Sprawdzanie szczegółów konta...\n";
    $accountDetails = $infakt->getAccountDetails();
    echo "Konto: " . ($accountDetails['company_name'] ?? 'Nieznane') . "\n\n";

    // 2. Tworzenie klienta za pomocą modelu
    echo "2. Tworzenie nowego klienta...\n";
    $customer = new CustomerModel();
    $customer->companyName = 'Przykładowa Firma Sp. z o.o.';
    $customer->street = 'ul. Testowa 123';
    $customer->city = 'Warszawa';
    $customer->postalCode = '00-001';
    $customer->country = 'PL';
    $customer->nip = '1234567890';
    $customer->email = 'kontakt@przyklad.pl';

    // Walidacja modelu
    $errors = $customer->validate();
    if (!empty($errors)) {
        echo "Błędy walidacji klienta:\n";
        print_r($errors);
    } else {
        $customerData = ['client' => $customer->getAll($customer)];
        $createdCustomer = $apiClient->customerModule->create($customerData);
        echo "Utworzono klienta o ID: " . $createdCustomer['id'] . "\n";
    }

    // 3. Lista klientów z paginacją
    echo "\n3. Pobieranie listy klientów...\n";
    $customers = $apiClient->customerModule->list([], 1, 5); // strona 1, 5 elementów
    echo "Znaleziono " . count($customers['entities'] ?? []) . " klientów\n";
    
    if (isset($customers['pagination'])) {
        $pagination = $customers['pagination'];
        echo "Strona: {$pagination['current_page']}/{$pagination['total_pages']}\n";
        echo "Łącznie elementów: {$pagination['total_items']}\n";
    }

    // 4. Wyszukiwanie klientów
    echo "\n4. Wyszukiwanie klientów...\n";
    $searchResults = $apiClient->customerModule->search('Przykładowa');
    echo "Znaleziono " . count($searchResults['entities'] ?? []) . " klientów pasujących do zapytania\n";

    // 5. Tworzenie faktury VAT
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
                        'unit_net_price' => 10000, // 100.00 PLN w groszach
                        'quantity' => 1
                    ]
                ]
            ]
        ];

        $invoice = $apiClient->vatInvoiceModule->create($invoiceData);
        echo "Utworzono fakturę o ID: " . $invoice['id'] . "\n";
        
        // Sprawdzenie statusu faktury
        $status = $apiClient->vatInvoiceModule->checkStatus($invoice['id']);
        echo "Status faktury: " . ($status['status'] ?? 'nieznany') . "\n";
    }

    // 6. Lista faktur z filtrami
    echo "\n6. Pobieranie listy faktur...\n";
    $invoices = $apiClient->vatInvoiceModule->list([
        'invoice_date_from' => date('Y-m-01'), // od początku miesiąca
        'invoice_date_to' => date('Y-m-d')     // do dzisiaj
    ], 1, 10);
    
    echo "Znaleziono " . count($invoices['entities'] ?? []) . " faktur w tym miesiącu\n";

    // 7. Sprawdzenie limitów API
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
