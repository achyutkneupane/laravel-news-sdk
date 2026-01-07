<?php

declare(strict_types=1);

namespace AchyutN\LaravelNews;

use AchyutN\LaravelNews\Data\Link;
use AchyutN\LaravelNews\Exceptions\LaravelNewsException;
use Illuminate\Support\Facades\Http;
use Throwable;

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
     * @return array<string, string|int>
     *
     * @throws LaravelNewsException
     */
    public function post(Link $link): array
    {
        $postURL = self::BASE_URL.'/links';
        try {
            $response = Http::acceptJson()
                ->withToken($this->token)
                ->post(
                    $postURL,
                    $link->toArray()
                );
            if ($response->failed()) {
                throw new LaravelNewsException(
                    'Laravel News API returned an error: '.$response->body(),
                    $response->status()
                );
            }

            /** @var array<string, string|int> */
            return $response->json();
        } catch (Throwable $throwable) {
            throw new LaravelNewsException(
                'Unexpected error while performing POST request.',
                1000,
                $throwable
            );
        }
    }
}
