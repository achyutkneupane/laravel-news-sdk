<?php

declare(strict_types=1);

namespace AchyutN\LaravelNews;

use AchyutN\LaravelNews\Data\Link;
use AchyutN\LaravelNews\Exceptions\LaravelNewsException;
use Illuminate\Support\Facades\Http;
use Throwable;

/**
 * @phpstan-import-type LinkArray from Link
 */
final class LaravelNews
{
    private const BASE_URL = 'https://laravel-news.com/api';

    public function __construct(
        private readonly string $token
    ) {
        //
    }

    /**
     * Send a POST request
     *
     * @throws LaravelNewsException
     */
    public function post(Link $link): Link
    {
        try {
            $response = Http::acceptJson()
                ->baseUrl(self::BASE_URL)
                ->withToken($this->token)
                ->post(
                    '/links',
                    $link->toPostArray()
                );
        } catch (Throwable $throwable) {
            throw new LaravelNewsException(
                'Unexpected error while performing POST request.',
                1000,
                $throwable
            );
        }

        $status = $response->status();
        /** @phpstan-var array{'data': LinkArray}|array{'message': string, 'errors'?: array<string, mixed>} $json */
        $json = $response->json();

        if ($status >= 400) {
            $errors = array_key_exists('errors', $json) && is_array($json['errors'])
                ? $json['errors']
                : [];

            $message = array_key_exists('message', $json) && is_string($json['message'])
                ? $json['message']
                : 'Laravel News API returned an error';

            throw new LaravelNewsException(
                sprintf('%s. Errors: %s', $message, json_encode($errors)),
                $status
            );
        }

        /** @var LinkArray $jsonItem */
        $jsonItem = array_key_exists('data', $json) && is_array($json['data'])
            ? $json['data']
            : [];

        return Link::fromArray($jsonItem);
    }
}
