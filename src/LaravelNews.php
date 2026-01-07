<?php

declare(strict_types=1);

namespace AchyutN\LaravelNews;

use AchyutN\LaravelNews\Data\Link;
use AchyutN\LaravelNews\Exceptions\LaravelNewsException;
use Illuminate\Support\Facades\Http;
use JsonException;
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
        } catch (Throwable $throwable) {
            throw new LaravelNewsException(
                'Unexpected error while performing POST request.',
                1000,
                $throwable
            );
        }

        $status = $response->status();

        if ($status >= 400) {
            /** @var array<string, string|array<string,string>> $json */
            $json = $response->json();

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

        $data = $response->json();
        if (! is_array($data)) {
            throw new LaravelNewsException(
                'Invalid JSON returned by Laravel News API.',
                1002
            );
        }

        return $data;
    }
}
