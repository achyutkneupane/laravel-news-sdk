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
}
