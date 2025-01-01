<?php

namespace SCA\InFakt\Client\Modules;

class VatInvoiceModule extends BaseModule
{
    CONST ENDPOINT = '/invoices';
    CONST ASYNC = '/async';
    CONST ENDPOINT_STATUS = '/status';
    public function create(array $data): array {
        return $this->request('POST', self:: ASYNC .    self::ENDPOINT . '.json', ['json' => $data]);
    }

    public function read(int $id): array {
        return $this->request('GET', self::ENDPOINT . "/{$id}");
    }

    public function update(int $id, array $data): array {
        return $this->request('PUT', self::ENDPOINT . "/{$id}", ['json' => $data]);
    }

    public function delete(int $id): bool {
        $this->request('DELETE', self::ENDPOINT . "/{$id}");
        return true;
    }

    public function checkStatus(string $id): array {
        return $this->request('GET', self::ASYNC . self::ENDPOINT . self::ENDPOINT_STATUS . "/{$id}");
    }
}