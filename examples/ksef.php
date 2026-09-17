<?php

use SCA\InFakt\Client\ApiClient;
use SCA\InFakt\Client\Authenticator;
use SCA\InFakt\Client\Modules\KsefModule;
use SCA\InFakt\Exception\ApiException;

require_once __DIR__ . '/../vendor/autoload.php';
$apiKey = 'your-api-key-here';
$apiClient = new ApiClient(new Authenticator($apiKey), sandbox: true);

try {
    if (!$apiClient->ksefModule->isIntegrated()) {
        echo "Konto nie jest zintegrowane z KSeF\n";
        exit(1);
    }

    $invoices = $apiClient->vatInvoiceModule->list([], 1, 1);
    $invoiceUuid = $invoices['entities'][0]['uuid'] ?? null;
    if (!$invoiceUuid) {
        echo "Brak faktur\n";
        exit(1);
    }

    $sent = $apiClient->ksefModule->send($invoiceUuid);
    echo "Zlecono wysyłkę: {$sent['status']} ({$sent['status_description']})\n";

    do {
        sleep(5);
        $status = $apiClient->ksefModule->status($invoiceUuid);
        echo "Status: {$status['status']}\n";
    } while (!KsefModule::isFinal($status['status']));

    if ($status['status'] === KsefModule::STATUS_SUCCESS) {
        echo "Numer KSeF: {$status['ksef_number']}\n";
    } else {
        echo "Błąd: {$status['status_description']}\n";
    }
} catch (ApiException $e) {
    echo "Błąd API ({$e->getCode()}): {$e->getMessage()}\n";
}
