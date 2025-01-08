<?php

namespace SCA\InFakt\Client\Modules;

class OssInvoiceModule extends BaseModule
{
    CONST ENDPOINT = '/oss_invoices';
    CONST ASYNC = '/async';
    public function create(array $data): array {
        return $this->request('POST', self::ENDPOINT . '.json', ['json' => $data]);
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
}