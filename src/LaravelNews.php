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
        //
    }

    /**
     * Post a new link to Laravel News.
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
                )
                ->throw(
                    function (Response $response, Throwable $throwable): never {
                        /** @var string $message */
                        $message = $response->json('message', 'Laravel News API error');

                        throw new LaravelNewsException($message, $response->status(), $throwable);
                    }
                );

            /** @var array{data: LinkArray} $payload */
            $payload = $response->json();

            return Link::fromArray($payload['data']);
        } catch (Throwable $throwable) {
            throw new LaravelNewsException(
                'Unexpected error while performing POST request.',
                1000,
                $throwable
            );
        }
    }
}
