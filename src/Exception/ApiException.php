<?php

namespace SCA\InFakt\Exception;

class ApiException extends InfaktException {
    private int $statusCode;
    private array $responseData;
    
    public function __construct(string $message, int $statusCode, array $responseData = [], \Throwable $previous = null) {
        parent::__construct($message, $statusCode, $previous);
        $this->statusCode = $statusCode;
        $this->responseData = $responseData;
    }

    public function getStatusCode(): int {
        return $this->statusCode;
    }

    public function getResponseData(): array {
        return $this->responseData;
    }
}
