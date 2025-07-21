<?php

namespace SCA\InFakt\Exception;

class ValidationException extends InfaktException
{
    private array $errors;
    public function __construct(array $errors, string $message = 'Validation failed', \Throwable $previous = null)
    {
        parent::__construct($message, 422, $previous);
        $this->errors = $errors;
    }
    public function getErrors(): array
    {
        return $this->errors;
    }
}
