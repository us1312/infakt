<?php

namespace SCA\InFakt\Client\Modules;

class VatInvoiceModule extends BaseModule
{
    const ENDPOINT = '/invoices';
    const ASYNC = '/async';
    const ENDPOINT_STATUS = '/status';
    const ENDPOINT_PAID = '/paid';
    public function create(array $data): array
    {
        return $this->request('POST', self::ASYNC . self::ENDPOINT . '.json', ['json' => $data]);
    }

    public function read(string $id): array
    {
        return $this->request('GET', self::ENDPOINT . "/{$id}.json");
    }

    public function update(int $id, array $data): array
    {
        return $this->request('PUT', self::ENDPOINT . "/{$id}", ['json' => $data]);
    }

    public function delete(int $id): bool
    {
        $this->request('DELETE', self::ENDPOINT . "/{$id}");
        return true;
    }

    public function checkStatus(string $id): array
    {
        return $this->request('GET', self::ASYNC . self::ENDPOINT . self::ENDPOINT_STATUS . "/{$id}.json");
    }

    public function markAsPaid(string $id, string $date): array
    {
        return $this->request('POST', self::ASYNC . self::ENDPOINT . "/{$id}" . self::ENDPOINT_PAID . ".json" . "?date={$date}");
    }

    public function downloadPdf(string $id): array|string
    {
        return $this->request('GET', self::ENDPOINT . "/{$id}/pdf.json?document_type=original");
    }

    public function list(array $filters = [], int $page = 1, int $limit = 20): array
    {
        $cleanFilters = $this->buildQueryParametersArray($filters);
        return $this->buildPaginatedRequest(self::ENDPOINT, $cleanFilters, $page, $limit);
    }

    public function search(array $search, int $page = 1, int $limit = 20): array
    {
        $cleanFilters = $this->buildQueryParametersArray($search);
        return $this->list($cleanFilters, $page, $limit);
    }

    public function findByNumber(string $number, int $page = 1, int $limit = 20): array
    {
        $cleanFilters = $this->buildQueryParametersArray(['number' => ['modifier' => 'eq', 'value' => $number]]);
        return $this->search($cleanFilters, $page, $limit);
    }

    public function findByClient(int $clientId, int $page = 1, int $limit = 20): array
    {
        $cleanFilters = $this->buildQueryParametersArray(['client_id' => ['modifier' => 'eq', 'value' => $clientId]]);
        return $this->list($cleanFilters, $page, $limit);
    }

    public function findByStatus(string $status, int $page = 1, int $limit = 20): array
    {
        $cleanFilters = $this->buildQueryParametersArray(['status' => ['modifier' => 'eq', 'value' => $status]]);
        return $this->list($cleanFilters, $page, $limit);
    }

    public function findByDateRange(string $dateFrom, string $dateTo, int $page = 1, int $limit = 20): array
    {
        $cleanFilters = $this->buildQueryParametersArray([
            'invoice_date_from' => ['modifier' => 'gte', 'value' => $dateFrom],
            'invoice_date_to' => ['modifier' => 'lte', 'value' => $dateTo]
        ]);
        return $this->list($cleanFilters, $page, $limit);
    }

    public function getAllInvoices(array $filters = []): array
    {
        return $this->getAllPages(self::ENDPOINT, $filters);
    }
}
