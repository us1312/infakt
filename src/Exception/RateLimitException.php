<?php

namespace SCA\InFakt\Exception;

class RateLimitException extends InfaktException
{
    private int $retryAfter;

    public function __construct(int $retryAfter = 60, string $message = 'Rate limit exceeded', \Throwable $previous = null)
    {
        parent::__construct($message, 429, $previous);
        $this->retryAfter = $retryAfter;
    }

    public function getRetryAfter(): int
    {
        return $this->retryAfter;
    }
}
