<?php

namespace SCA\InFakt\Client\Modules;
use SCA\InFakt\Client\ApiClient;
use SCA\InFakt\Util\Pagination;

abstract class BaseModule
{
    public function __construct(protected ApiClient $client) {}

    protected function buildQueryParametersArray(array $filters) {
        $allowedModifiers = ['eq', 'cont', 'lt', 'gt', 'lteq', 'greq'];
        $cleanFilters = [];
        foreach ($filters as $fieldName => $filterData) {
            if (!is_array($filterData) || !isset($filterData['modifier']) || !isset($filterData['value'])) {
                throw new \InvalidArgumentException("Invalid filter structure for field '{$fieldName}'. Expected array with 'modifier' and 'value' keys.");
            }
            $modifier = $filterData['modifier'];
            $value = $filterData['value'];
            if (!in_array($modifier, $allowedModifiers, true)) {
                throw new \InvalidArgumentException("Invalid modifier '{$modifier}' for field '{$fieldName}'. Allowed modifiers: " . implode(', ', $allowedModifiers));
            }
            $cleanFilters['q[' . $fieldName . '_' . $modifier . ']'] = $value;
        }

        return $cleanFilters;
    }

    protected function request(string $method, string $endpoint, array $options = []): array | string{
        return $this->client->request($method, $endpoint, $options);
    }

    protected function buildPaginatedRequest(string $endpoint, array $filters = [], int $page = 1, int $limit = 20): array
    {
        $queryParams = Pagination::buildQueryParams($page, $limit, $filters);
        $query = !empty($queryParams) ? '?' . http_build_query($queryParams) : '';
        $response = $this->request('GET', $endpoint . '.json' . $query);
        if (isset($response['metainfo'])) {
            $pagination = new Pagination($response['metainfo'], $page, $limit);
            $response['pagination'] = $pagination->toArray();
        }
        return $response;
    }

    protected function getAllPages(string $endpoint, array $filters = [], int $limit = 100): array
    {
        $allItems = [];
        $page = 1;
        do {
            $response = $this->buildPaginatedRequest($endpoint, $filters, $page, $limit);
            if (isset($response['entities']) && is_array($response['entities'])) {
                $allItems = array_merge($allItems, $response['entities']);
            }
            $hasNext = $response['pagination']['has_next'] ?? false;
            $page++;
        } while ($hasNext);

        return $allItems;
    }
}
