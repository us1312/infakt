<?php

namespace SCA\InFakt\Util;

use SCA\InFakt\Exception\RateLimitException;

class RateLimiter
{
    private array $requests = [];
    private int $maxRequests;
    private int $timeWindow;
    private int $minInterval;

    public function __construct(int $maxRequests = 100, int $timeWindow = 3600, int $minInterval = 1)
    {
        $this->maxRequests = $maxRequests;
        $this->timeWindow = $timeWindow;
        $this->minInterval = $minInterval;
    }

    public function checkLimit(): void
    {
        $now = time();
        
        // Sprawdź minimalny interwał między requestami
        if (!empty($this->requests)) {
            $lastRequest = end($this->requests);
            if ($now - $lastRequest < $this->minInterval) {
                $waitTime = $this->minInterval - ($now - $lastRequest);
                throw new RateLimitException($waitTime, 'Minimum interval between requests not met');
            }
        }

        // Usuń stare requesty spoza okna czasowego
        $this->requests = array_filter($this->requests, function($timestamp) use ($now) {
            return $now - $timestamp < $this->timeWindow;
        });

        // Sprawdź czy nie przekroczono limitu
        if (count($this->requests) >= $this->maxRequests) {
            $oldestRequest = min($this->requests);
            $waitTime = $this->timeWindow - ($now - $oldestRequest);
            throw new RateLimitException($waitTime, 'Rate limit exceeded');
        }
    }

    public function recordRequest(): void
    {
        $this->requests[] = time();
    }

    public function getRemainingRequests(): int
    {
        $now = time();
        $this->requests = array_filter($this->requests, function($timestamp) use ($now) {
            return $now - $timestamp < $this->timeWindow;
        });

        return max(0, $this->maxRequests - count($this->requests));
    }

    public function getResetTime(): int
    {
        if (empty($this->requests)) {
            return time();
        }

        $oldestRequest = min($this->requests);
        return $oldestRequest + $this->timeWindow;
    }

    public function waitIfNeeded(): void
    {
        try {
            $this->checkLimit();
        } catch (RateLimitException $e) {
            sleep($e->getRetryAfter());
        }
    }

    public function getStats(): array
    {
        return [
            'max_requests' => $this->maxRequests,
            'time_window' => $this->timeWindow,
            'remaining_requests' => $this->getRemainingRequests(),
            'reset_time' => $this->getResetTime(),
            'current_requests' => count($this->requests)
        ];
    }
}
