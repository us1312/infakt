<?php
namespace SCA\InFakt\Exception;
class AuthenticationException extends InfaktException
{
    public function __construct(string $message = 'Authentication failed', \Throwable $previous = null)
    {
        parent::__construct($message, 401, $previous);
    }
}
