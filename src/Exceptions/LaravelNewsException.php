<?php

declare(strict_types=1);

namespace AchyutN\LaravelNews\Exceptions;

use Exception;
use Throwable;

/**
 * Base exception for all Laravel News SDK errors.
 */
final class LaravelNewsException extends Exception
{
    public function __construct(
        string $message = 'An error occurred with Laravel News.',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public static function networkError(Throwable $previous): self
    {
        return new self('Network error while communicating with Laravel News.', 1001, $previous);
    }

    public static function invalidResponse(?string $response = null): self
    {
        $msg = 'Invalid JSON returned by Laravel News API.';
        if ($response !== null) {
            $msg .= ' Response: '.mb_substr($response, 0, 200).'...';
        }

        return new self($msg, 1002);
    }
}
