<?php

declare(strict_types=1);

namespace AchyutN\LaravelNews\Providers;

use AchyutN\LaravelNews\Exceptions\LaravelNewsException;
use AchyutN\LaravelNews\LaravelNews;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

final class LaravelNewsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/laravel-news.php', 'laravel-news');

        $this->app->singleton(
            LaravelNews::class,
            function (Application $app): LaravelNews {
                /** @var Repository $config */
                $config = $app->make('config');

                /**
                 * @var string $token
                 */
                $token = $config->get('laravel-news.token');

                $this->ensureTokenIsPresent($token);

                return new LaravelNews($token);
            }
        );
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/laravel-news.php' => $this->app->configPath('laravel-news.php'),
            ], 'laravel-news');
        }
    }

    private function ensureTokenIsPresent(string $token): void
    {
        if (trim($token) === '') {
            throw new LaravelNewsException('API token is required to communicate with Laravel News.');
        }
    }
}
