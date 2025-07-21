<?php

namespace SCA\InFakt\Client\Modules;

class OssTaxRates extends BaseModule {
    const ENDPOINT = '/moss_vat_rates.json?limit=100&offset=0';
    private array $countryEntities = [];
    private array $metaInfo = [];

    public function getOssTaxRates(string $country): array {
        $endpoint = self::ENDPOINT;
        $allRates = [];
        $processedCount = 0;
        do {
            if (!$this->countryEntities) {
                $response = $this->request('GET', $endpoint);
                if (!isset($response['entities'], $response['metainfo']) || !is_array($response['entities'])) {
                    throw new \Exception('Invalid response from API.');
                }
                $this->countryEntities = $response['entities'];
                $this->metaInfo = $response['metainfo'];
            }
            $processedCount += count($this->countryEntities);
            foreach ($this->countryEntities as $rate) {
                if ($rate['country'] === $country && !$rate['reduced']) {
                    $allRates[] = $rate;
                    break 2;
                }
            }
            $endpoint = $this->metaInfo['next'] ?? null;
        } while ($endpoint && $processedCount < $this->metaInfo['total_count']);

        return $allRates;
    }
}