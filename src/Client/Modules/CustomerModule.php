<?php

namespace SCA\InFakt\Client\Modules;

class CustomerModule extends BaseModule
{
    const ENDPOINT = '/clients';

    public function create(array $data): array
    {
        return $this->request('POST', self::ENDPOINT . '.json', ['json' => $data]);
    }

    public function read(int $id): array
    {
        return $this->request('GET', self::ENDPOINT . "/{$id}.json");
    }

    public function update(int $id, array $data): array
    {
        return $this->request('PUT', self::ENDPOINT . "/{$id}.json", ['json' => $data]);
    }

    public function delete(int $id): bool
    {
        $this->request('DELETE', self::ENDPOINT . "/{$id}.json");
        return true;
    }

    public function list(array $filters = [], int $page = 1, int $limit = 20): array
    {
        $cleanFilters = $this->buildQueryParametersArray($filters);
        return $this->buildPaginatedRequest(self::ENDPOINT, $cleanFilters, $page, $limit);
    }

    public function search(array $filters, int $page = 1, int $limit = 20): array
    {
        $cleanFilters = $this->buildQueryParametersArray($filters);
        return $this->list($cleanFilters, $page, $limit);
    }

    public function findByNip(string $nip, int $page = 1, int $limit = 20): array
    {
        $cleanFilters = $this->buildQueryParametersArray(['nip' => ['modifier' => 'eq', 'value' => $nip]]);
        return $this->search($cleanFilters, $page, $limit);
    }

    public function findByEmail(string $email, int $page = 1, int $limit = 20): array
    {
        $cleanFilters = $this->buildQueryParametersArray(['email' => ['modifier' => 'eq', 'value' => $email]]);
        return $this->search($cleanFilters, $page, $limit);
    }

    public function findByCompanyName(string $companyName, int $page = 1, int $limit = 20): array
    {
        $cleanFilters = $this->buildQueryParametersArray(['company_name' => ['modifier' => 'eq', 'value' => $companyName]]);
        return $this->search($companyName, $page, $limit);
    }

    public function getAllCustomers(array $filters = []): array
    {
        return $this->getAllPages(self::ENDPOINT, $filters);
    }
}
