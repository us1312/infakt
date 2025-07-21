<?php

namespace SCA\InFakt\Util;

class Pagination {
    private int $currentPage;
    private int $perPage;
    private int $totalItems;
    private int $totalPages;
    private ?string $nextUrl;
    private ?string $prevUrl;

    public function __construct(array $metainfo, int $currentPage = 1, int $perPage = 20) {
        $this->currentPage = $currentPage;
        $this->perPage = $perPage;
        $this->totalItems = $metainfo['total_count'] ?? 0;
        $this->totalPages = (int) ceil($this->totalItems / $this->perPage);
        $this->nextUrl = $metainfo['next'] ?? null;
        $this->prevUrl = $metainfo['previous'] ?? null;
    }

    public function getCurrentPage(): int {
        return $this->currentPage;
    }

    public function getPerPage(): int {
        return $this->perPage;
    }

    public function getTotalItems(): int {
        return $this->totalItems;
    }

    public function getTotalPages(): int {
        return $this->totalPages;
    }

    public function hasNextPage(): bool {
        return $this->nextUrl !== null;
    }

    public function hasPrevPage(): bool {
        return $this->prevUrl !== null;
    }

    public function getNextUrl(): ?string {
        return $this->nextUrl;
    }

    public function getPrevUrl(): ?string {
        return $this->prevUrl;
    }

    public function getOffset(): int {
        return ($this->currentPage - 1) * $this->perPage;
    }

    public function isFirstPage(): bool {
        return $this->currentPage === 1;
    }

    public function isLastPage(): bool {
        return $this->currentPage === $this->totalPages;
    }

    public function toArray(): array {
        return [
            'current_page' => $this->currentPage,
            'per_page' => $this->perPage,
            'total_items' => $this->totalItems,
            'total_pages' => $this->totalPages,
            'has_next' => $this->hasNextPage(),
            'has_prev' => $this->hasPrevPage(),
            'next_url' => $this->nextUrl,
            'prev_url' => $this->prevUrl,
            'is_first' => $this->isFirstPage(),
            'is_last' => $this->isLastPage()
        ];
    }

    public static function buildQueryParams(int $page = 1, int $limit = 20, array $additionalParams = []): array {
        $params = [
            'limit' => $limit,
            'offset' => ($page - 1) * $limit
        ];

        return array_merge($params, $additionalParams);
    }
}
