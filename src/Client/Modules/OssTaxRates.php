<?php

namespace SCA\InFakt\Client\Modules;

class OssTaxRates extends BaseModule
{
    const ENDPOINT = '/moss_vat_rates.json?limit=100&offset=0';

    public function getOssTaxRates(string $country): array
    {
        $endpoint = self::ENDPOINT;
        $allRates = [];
        $processedCount = 0;

        do {
            $response = $this->request('GET', $endpoint);

            if (!isset($response['entities'], $response['metainfo']) || !is_array($response['entities'])) {
                throw new \Exception('Invalid response from API.');
            }

            $processedCount += count($response['entities']);

            foreach ($response['entities'] as $rate) {
                if ($rate['country'] === $country && !$rate['reduced']) {
                    $allRates[] = $rate;

                    break 2;
                }
            }

            $endpoint = $response['metainfo']['next'] ?? null;

        } while ($endpoint && $processedCount < $response['metainfo']['total_count']);

        return $allRates;
    }
}