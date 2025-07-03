<?php

namespace SCA\InFakt\Client\Modules;

class CustomerModule extends BaseModule
{
    CONST ENDPOINT = '/clients';

    public function create(array $data): array {
        return $this->request('POST', self::ENDPOINT . '.json', ['json' => $data]);
    }
}