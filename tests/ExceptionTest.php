<?php

declare(strict_types=1);

use AchyutN\LaravelNews\Exceptions\LaravelNewsException;

it('creates network error exception', function () {
    $previous = new RuntimeException('Network down');

    $exception = LaravelNewsException::networkError($previous);

    expect($exception->getMessage())
        ->toBe('Network error while communicating with Laravel News.')
        ->and($exception->getCode())->toBe(1001)
        ->and($exception->getPrevious())->toBe($previous);
});

it('creates invalid response exception with response body', function () {
    $exception = LaravelNewsException::invalidResponse('Invalid HTML');

    expect($exception->getMessage())
        ->toContain('Invalid JSON returned by Laravel News API.')
        ->toContain('Invalid HTML')
        ->and($exception->getCode())->toBe(1002);
});
