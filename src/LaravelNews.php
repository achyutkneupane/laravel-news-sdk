<?php

declare(strict_types=1);

namespace AchyutN\LaravelNews;

use AchyutN\LaravelNews\Data\Link;
use AchyutN\LaravelNews\Exceptions\LaravelNewsException;
use Illuminate\Http\Client\Response;
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
        $this->ensureTokenIsPresent();
    }

    /**
     * Post a new link to Laravel News.
     *
     * @throws LaravelNewsException
     */
    public function post(Link $link): Link
    {
        $response = Http::acceptJson()
            ->baseUrl(self::BASE_URL)
            ->withToken($this->token)
            ->post(
                '/links',
                $link->toPostArray()
            );

        if ($response->failed()) {
            $this->handleException($response);
        }

        /** @var array{data: LinkArray} $payload */
        $payload = $response->json();

        return Link::fromArray($payload['data']);
    }

    /**
     * Check if the API token is provided.
     */
    private function ensureTokenIsPresent(): void
    {
        if (trim($this->token) === '') {
            throw new LaravelNewsException('API token is required to communicate with Laravel News.');
        }
    }

    /**
     * Handle a failed API response.
     *
     * @throws LaravelNewsException
     */
    private function handleException(Response $response): never
    {
        /** @var string $message */
        $message = $response->json('message', 'Unexpected error while performing POST request.');

        throw new LaravelNewsException($message, $response->status());
    }
}
