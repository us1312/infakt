<?php

namespace SCA\InFakt\Client\Modules;

class KsefModule extends BaseModule {
    const ENDPOINT = '/ksef2';
    const DOCUMENTS = '/documents';

    const STATUS_PENDING = 'pending';
    const STATUS_SENT = 'sent';
    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';
    const STATUS_REJECTED = 'rejected';

    public function integrationStatus(): array {
        return $this->request('GET', self::ENDPOINT . '/integration.json');
    }

    public function isIntegrated(): bool {
        return (bool)($this->integrationStatus()['active'] ?? false);
    }

    public function send(string $documentUuid): array {
        return $this->request('POST', self::ENDPOINT . self::DOCUMENTS . "/{$documentUuid}/send.json");
    }

    /**
     * @param string[] $documentUuids
     * @return array<int, array>
     */
    public function sendMany(array $documentUuids): array {
        $response = $this->request('POST', self::ENDPOINT . self::DOCUMENTS . '/send.json', ['json' => ['uuids' => array_values($documentUuids)]]);

        return $response['entities'] ?? $response;
    }

    public function status(string $documentUuid): array {
        return $this->request('GET', self::ENDPOINT . self::DOCUMENTS . "/{$documentUuid}/status.json");
    }

    public function downloadXml(string $documentUuid): array|string {
        return $this->request('GET', self::ENDPOINT . self::DOCUMENTS . "/{$documentUuid}/download_xml.json");
    }

    public function importIncomes(array $filters = [], int $offset = 0, int $limit = 20): array {
        return $this->import('incomes', $filters, $offset, $limit);
    }

    public function importCosts(array $filters = [], int $offset = 0, int $limit = 20): array {
        return $this->import('costs', $filters, $offset, $limit);
    }

    public function importByKsefNumber(string $ksefNumber): array|string {
        return $this->request('GET', self::ENDPOINT . "/import/{$ksefNumber}.json");
    }

    public static function isFinal(?string $status): bool {
        return in_array($status, [self::STATUS_SUCCESS, self::STATUS_ERROR, self::STATUS_REJECTED], true);
    }

    private function import(string $kind, array $filters, int $offset, int $limit): array {
        $query = array_merge(['offset' => $offset, 'limit' => $limit], $this->buildQueryParametersArray($filters));

        return $this->request('GET', self::ENDPOINT . "/import/{$kind}.json?" . http_build_query($query));
    }
}
