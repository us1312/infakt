<?php

namespace SCA\InFakt\Client\Modules;

class OssInvoiceModule extends BaseModule {
    const ENDPOINT = '/oss_invoices';
    const ASYNC = '/async';

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

    public function downloadPdf(string $id): array|string {
        return $this->request('GET', self::ENDPOINT . "/{$id}/pdf.json?document_type=original");
    }

    public function list(array $filters = [], int $page = 1, int $limit = 20): array {
        $cleanFilters = $this->buildQueryParametersArray($filters);

        return $this->buildPaginatedRequest(self::ENDPOINT, $cleanFilters, $page, $limit);
    }

    public function search(array $query, int $page = 1, int $limit = 20): array {
        return $this->list($query, $page, $limit);
    }

    public function findByCountry(string $country, int $page = 1, int $limit = 20): array {
        return $this->list(['country' => ['modifier' => 'eq', 'value' => $country]], $page, $limit);
    }

    public function findByDateRange(string $dateFrom, string $dateTo, int $page = 1, int $limit = 20): array {
        return $this->list([
            'issue_date_from' => ['modifier' => 'gte', 'value' => $dateFrom],
            'issue_date_to' => ['modifier' => 'lte', 'value' => $dateTo]
        ], $page, $limit);
    }

    public function getAllOssInvoices(array $filters = []): array {
        $cleanFilters = $this->buildQueryParametersArray($filters);

        return $this->getAllPages(self::ENDPOINT, $cleanFilters);
    }
}
