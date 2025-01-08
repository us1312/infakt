<?php

namespace SCA\InFakt\Client\Modules;

class VatInvoiceModule extends BaseModule
{
    CONST ENDPOINT = '/invoices';
    CONST ASYNC = '/async';
    CONST ENDPOINT_STATUS = '/status';
    CONST ENDPOINT_PAID = '/paid';
    public function create(array $data): array {
        return $this->request('POST', self:: ASYNC .    self::ENDPOINT . '.json', ['json' => $data]);
    }

    public function read(string $id): array {
        return $this->request('GET', self::ENDPOINT . "/{$id}.json");
    }

    public function update(int $id, array $data): array {
        return $this->request('PUT', self::ENDPOINT . "/{$id}", ['json' => $data]);
    }

    public function delete(int $id): bool {
        $this->request('DELETE', self::ENDPOINT . "/{$id}");
        return true;
    }

    public function checkStatus(string $id): array {
        return $this->request('GET', self::ASYNC . self::ENDPOINT . self::ENDPOINT_STATUS . "/{$id}.json");
    }

    public function markAsPaid(string $id, string $date): array {
        return $this->request('POST', self::ASYNC . self::ENDPOINT  . "/{$id}" . self::ENDPOINT_PAID . ".json" . "?date={$date}");
    }
    
    public function downloadPdf(string $id): array | string {
        return $this->request('GET', self::ENDPOINT . "/{$id}/pdf.json?document_type=original");
    }
}