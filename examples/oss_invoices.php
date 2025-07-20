<?php

require_once __DIR__ . '/../../.././../vendor/autoload.php';

use SCA\InFakt\Client\ApiClient;
use SCA\InFakt\Client\Authenticator;
use SCA\InFakt\Model\OssInvoiceModel;
use SCA\InFakt\Model\OssInvoiceProductModel;

// Konfiguracja
$apiKey = '454a4dca3a82308f478398aec8b24f65ec291202';
$sandbox = true;

try {
    xdebug_break();
    echo "=== InFakt API Client - Faktury OSS ===\n\n";

    // Inicjalizacja
    $authenticator = new Authenticator($apiKey);
    $apiClient = new ApiClient($authenticator, $sandbox);

//    // 1. Pobieranie stawek podatkowych OSS dla różnych krajów
//    echo "1. Pobieranie stawek podatkowych OSS...\n";
//    $countries = ['DE', 'FR', 'IT', 'ES', 'NL'];
//
//    foreach ($countries as $country) {
//        try {
//            $taxRates = $apiClient->ossTaxRates->getOssTaxRates($country);
//            if (!empty($taxRates)) {
//                $rate = $taxRates[0];
//                echo "  {$country}: {$rate['rate']}%\n";
//            } else {
//                echo "  {$country}: Brak danych\n";
//            }
//        } catch (Exception $e) {
//            echo "  {$country}: Błąd - {$e->getMessage()}\n";
//        }
//    }
//
    // 2. Tworzenie faktury OSS za pomocą modelu
    echo "\n2. Tworzenie faktury OSS...\n";

    $ossInvoice = new OssInvoiceModel();
    $ossInvoice->country = 'DE';
    $ossInvoice->clientFirstName = 'Hans';
    $ossInvoice->clientLastName = 'Mueller';
    $ossInvoice->clientEmail = 'hans.mueller@example.de';
    $ossInvoice->clientStreet = 'Hauptstraße 123';
    $ossInvoice->clientCity = 'Berlin';
    $ossInvoice->clientPostCode = '10115';
    $ossInvoice->saleType = 'merchandise';
    $ossInvoice->servicePlacePrimary = 'customer_country';
    $ossInvoice->currency = 'EUR';
    $ossInvoice->issueDate = date('Y-m-d');
    $ossInvoice->serviceDate = date('Y-m-d');
    $ossInvoice->paymentDate = $ossInvoice->serviceDate;

    // Dodanie produktu/usługi
    $product = new OssInvoiceProductModel();
    $product->name = 'Digital Marketing Service';
    $product->grossPrice = 11900; // 119.00 EUR w centach
    $product->quantity = 1;
    $product->taxRate = 19; // 19% VAT dla Niemiec
    $product->unit = 'szt';

    $ossInvoice->services = [$product->getAll($product)];

    // Walidacja
    $errors = $ossInvoice->validate();
    if (!empty($errors)) {
        echo "Błędy walidacji faktury OSS:\n";
        print_r($errors);
    } else {
        $invoiceData = ['oss_invoice' => $ossInvoice->getAll($ossInvoice)];
        $createdInvoice = $apiClient->ossInvoiceModule->create($invoiceData);
        echo "Utworzono fakturę OSS o ID: " . $createdInvoice['id'] . "\n";
        $invoiceId = $createdInvoice['id'];
    }
//
//    // 3. Lista faktur OSS z filtrami
//    echo "\n3. Lista faktur OSS...\n";
//    $ossInvoices = $apiClient->ossInvoiceModule->list([
//        'issue_date_from' => date('Y-m-01'),
//        'issue_date_to' => date('Y-m-d')
//    ], 1, 10);
//
//    echo "Faktury OSS w tym miesiącu: " . count($ossInvoices['entities'] ?? []) . "\n";
//
//    // 4. Faktury OSS według krajów
//    echo "\n4. Faktury OSS według krajów...\n";
//    $countriesWithInvoices = ['DE', 'FR', 'IT', 'ES'];
//
//    foreach ($countriesWithInvoices as $country) {
//        $countryInvoices = $apiClient->ossInvoiceModule->findByCountry($country, 1, 5);
//        $count = count($countryInvoices['entities'] ?? []);
//        echo "  {$country}: {$count} faktur\n";
//    }
//
//    // 5. Odczyt szczegółów faktury OSS
//    if (isset($invoiceId)) {
//        echo "\n5. Szczegóły faktury OSS...\n";
//        $invoiceDetails = $apiClient->ossInvoiceModule->read($invoiceId);
//        echo "Numer faktury: " . ($invoiceDetails['number'] ?? 'Brak') . "\n";
//        echo "Kwota brutto: " . ($invoiceDetails['gross_price'] ?? 0) / 100 . " " . ($invoiceDetails['currency'] ?? 'EUR') . "\n";
//        echo "Status: " . ($invoiceDetails['status'] ?? 'Nieznany') . "\n";
//    }
//
    // 6. Pobieranie PDF faktury OSS
//    if (isset($invoiceId)) {
//        echo "\n6. Pobieranie PDF faktury OSS...\n";
//        try {
//            $pdfContent = $apiClient->ossInvoiceModule->downloadPdf($invoiceId);
//            if (is_string($pdfContent)) {
//                $filename = "oss_invoice_{$invoiceId}.pdf";
//                file_put_contents($filename, $pdfContent);
//                echo "PDF zapisany jako: {$filename}\n";
//            } else {
//                echo "PDF nie jest jeszcze gotowy lub wystąpił błąd\n";
//            }
//        } catch (Exception $e) {
//            echo "Błąd pobierania PDF: " . $e->getMessage() . "\n";
//        }
//    }

    // 7. Wyszukiwanie faktur OSS
    echo "\n7. Wyszukiwanie faktur OSS...\n";
    $searchResults = $apiClient->ossInvoiceModule->search(
        [
            'client_name' => ['modifier' => 'eq', 'value' => 'Hans'],
        ],
        1,
        5
    );
    echo "Znaleziono " . count($searchResults['entities'] ?? []) . " faktur zawierających 'Digital'\n";

    // 8. Faktury OSS z zakresu dat
    echo "\n8. Faktury OSS z ostatnich 30 dni...\n";
    $dateFrom = date('Y-m-d', strtotime('-30 days'));
    $dateTo = date('Y-m-d');
    
    $recentInvoices = $apiClient->ossInvoiceModule->findByDateRange($dateFrom, $dateTo, 1, 20);
    echo "Faktury z ostatnich 30 dni: " . count($recentInvoices['entities'] ?? []) . "\n";

    // 9. Wszystkie faktury OSS (wszystkie strony)
    echo "\n9. Pobieranie wszystkich faktur OSS...\n";
    $allOssInvoices = $apiClient->ossInvoiceModule->getAllOssInvoices([
        'issue_date_from' => date('Y-01-01') // od początku roku
    ]);
    echo "Łączna liczba faktur OSS w tym roku: " . count($allOssInvoices) . "\n";

    // 10. Statystyki faktur OSS według krajów
    echo "\n10. Statystyki faktur OSS według krajów...\n";
    $stats = [];
    
    foreach ($allOssInvoices as $invoice) {
        $country = $invoice['country'] ?? 'Unknown';
        if (!isset($stats[$country])) {
            $stats[$country] = ['count' => 0, 'total_gross' => 0];
        }
        $stats[$country]['count']++;
        $stats[$country]['total_gross'] += $invoice['gross_price'] ?? 0;
    }
    
    foreach ($stats as $country => $data) {
        $totalGross = $data['total_gross'] / 100; // konwersja z centów
        echo "  {$country}: {$data['count']} faktur, łączna kwota: {$totalGross} EUR\n";
    }

} catch (Exception $e) {
    echo "Błąd: " . $e->getMessage() . "\n";
    echo "Typ: " . get_class($e) . "\n";
}

echo "\n=== Koniec przykładu OSS ===\n";
