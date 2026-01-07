<?php

declare(strict_types=1);

use AchyutN\LaravelNews\Exceptions\LaravelNewsException;

it('creates network error exception', function () {
    $previous = new RuntimeException('Network down');

    $exception = new LaravelNewsException(
        'Network error while communicating with Laravel News.',
        1001,
        $previous
    );

    expect($exception->getMessage())
        ->toBe('Network error while communicating with Laravel News.')
        ->and($exception->getCode())->toBe(1001)
        ->and($exception->getPrevious())->toBe($previous);
});
