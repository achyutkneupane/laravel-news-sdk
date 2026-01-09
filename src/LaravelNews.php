<?php

declare(strict_types=1);

namespace AchyutN\LaravelNews;

use AchyutN\LaravelNews\Data\Link;
use AchyutN\LaravelNews\Exceptions\LaravelNewsException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

/**
 * @phpstan-import-type LinkArray from Link
 */
final readonly class LaravelNews
{
    private const BASE_URL = 'https://laravel-news.com/api';

    public function __construct(
        private string $token
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
            ->contentType('application/json')
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
        /** @var string|null $message */
        $message = $response->json('message') ?? null;

        $statusCode = $response->status();

        if ($response->forbidden()) {
            throw new LaravelNewsException(
                $message ?? 'Forbidden. Check API token or permissions.',
                $statusCode,
            );
        }

        if ($response->status() === 422 && $response->json('errors')) {
            throw new LaravelNewsException(
                $message ?? 'Validation failed for the data.',
                $statusCode,
            );
        }

        throw new LaravelNewsException(
            $message ?? 'An error occurred while communicating with Laravel News API.',
            $statusCode);
    }
}
