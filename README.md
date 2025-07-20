# SCA InFakt API Client

Biblioteka PHP do łączenia się z API serwisu InFakt.pl - polskiego systemu do wystawiania faktur online.

## ✨ Funkcje

- ✅ **Kompletne API** - obsługa faktur VAT, OSS, klientów i stawek podatkowych
- ✅ **Modele danych** - wygodne klasy z walidacją
- ✅ **Paginacja** - automatyczna obsługa stronicowania wyników
- ✅ **Rate limiting** - ochrona przed przekroczeniem limitów API
- ✅ **Logowanie** - integracja z PSR-3 loggerami
- ✅ **Obsługa błędów** - dedykowane wyjątki dla różnych scenariuszy
- ✅ **Walidacja** - sprawdzanie NIP, email, kodów krajów
- ✅ **Sandbox** - tryb testowy dla bezpiecznego rozwoju

## 📦 Instalacja

```bash
composer require sca/infakt
```

## 🚀 Szybki start

```php
use SCA\InFakt\Infakt;
use SCA\InFakt\Client\ApiClient;
use SCA\InFakt\Client\Authenticator;

// Konfiguracja
$authenticator = new Authenticator('your-api-key');
$apiClient = new ApiClient($authenticator, true); // true = sandbox
$infakt = new Infakt($apiClient);

// Sprawdzenie konta
$account = $infakt->getAccountDetails();

// Lista klientów
$customers = $apiClient->customerModule->list([], 1, 20);

// Tworzenie faktury
$invoice = $apiClient->vatInvoiceModule->create([
    'invoice' => [
        'client_id' => 123,
        'invoice_date' => '2024-01-15',
        'services' => [
            [
                'name' => 'Usługa IT',
                'tax_symbol' => 'vat_23',
                'unit_net_price' => 10000,
                'quantity' => 1
            ]
        ]
    ]
]);
```

## 📚 Dokumentacja

### Klienci

```php
// CRUD operacje
$customer = $apiClient->customerModule->create($data);
$customer = $apiClient->customerModule->read(123);
$apiClient->customerModule->update(123, $data);
$apiClient->customerModule->delete(123);

// Listy i wyszukiwanie
$customers = $apiClient->customerModule->list([], 1, 20);
$results = $apiClient->customerModule->search('Firma');
$results = $apiClient->customerModule->findByNip('1234567890');

// Wszystkie strony
$allCustomers = $apiClient->customerModule->getAllCustomers();
```

### Faktury VAT

```php
// Tworzenie i zarządzanie
$invoice = $apiClient->vatInvoiceModule->create($data);
$status = $apiClient->vatInvoiceModule->checkStatus($invoiceId);
$apiClient->vatInvoiceModule->markAsPaid($invoiceId, '2024-01-20');

// Filtrowanie
$invoices = $apiClient->vatInvoiceModule->findByClient(123);
$invoices = $apiClient->vatInvoiceModule->findByStatus('paid');
$invoices = $apiClient->vatInvoiceModule->findByDateRange('2024-01-01', '2024-01-31');

// PDF
$pdfContent = $apiClient->vatInvoiceModule->downloadPdf($invoiceId);
```

### Faktury OSS

```php
// Stawki podatkowe
$taxRates = $apiClient->ossTaxRates->getOssTaxRates('DE');

// Faktury OSS
$ossInvoice = $apiClient->ossInvoiceModule->create($data);
$invoices = $apiClient->ossInvoiceModule->findByCountry('DE');
```

## 🛡️ Obsługa błędów

```php
use SCA\InFakt\Exception\{ApiException, ValidationException, RateLimitException};

try {
    $invoice = $apiClient->vatInvoiceModule->create($data);
} catch (ValidationException $e) {
    echo "Błędy walidacji: " . implode(', ', $e->getErrors());
} catch (RateLimitException $e) {
    echo "Rate limit! Czekaj " . $e->getRetryAfter() . " sekund";
} catch (ApiException $e) {
    echo "Błąd API: " . $e->getMessage();
}
```

## ⚡ Zaawansowane funkcje

### Rate Limiting

```php
use SCA\InFakt\Util\RateLimiter;

$rateLimiter = new RateLimiter(
    maxRequests: 100,
    timeWindow: 3600,
    minInterval: 1
);

$apiClient = new ApiClient($authenticator, false, $rateLimiter);
```

### Logowanie

```php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logger = new Logger('infakt');
$logger->pushHandler(new StreamHandler('infakt.log'));

$apiClient = new ApiClient($authenticator, false, null, null, $logger);
```

### Walidacja modeli

```php
use SCA\InFakt\Model\CustomerModel;

$customer = new CustomerModel();
$customer->companyName = 'Test';
$customer->country = 'PL';

// Walidacja
$errors = $customer->validate();
if (empty($errors)) {
    $data = ['client' => $customer->getAll($customer)];
    $result = $apiClient->customerModule->create($data);
}
```

## 📋 Przykłady

Sprawdź katalog `examples/`:
- `basic_usage.php` - podstawowe operacje
- `advanced_features.php` - zaawansowane funkcje
- `oss_invoices.php` - faktury OSS

## 🔄 Changelog

### v1.1.0
- ✅ Kompletne metody CRUD dla wszystkich modułów
- ✅ Paginacja z automatyczną obsługą
- ✅ Rate limiting i logowanie
- ✅ Rozszerzona walidacja
- ✅ Custom exceptions
- ✅ Metody `getAllPages()`

## 📄 Licencja

MIT License

## 🆘 Wsparcie

- GitHub Issues: [Zgłoś problem](https://github.com/us1312/infakt/issues)
- Dokumentacja API: https://docs.infakt.pl/
