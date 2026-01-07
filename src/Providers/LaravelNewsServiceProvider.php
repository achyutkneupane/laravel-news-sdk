<?php

declare(strict_types=1);

namespace AchyutN\LaravelNews\Providers;

use AchyutN\LaravelNews\LaravelNews;
use Illuminate\Support\ServiceProvider;

final class LaravelNewsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-news.php', 'laravel-news');

        $this->app->singleton(
            LaravelNews::class,
            function () {
                /** @var string $token */
                $token = config('laravel-news.token') ?? '';

                return new LaravelNews($token);
            }
        );
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/laravel-news.php' => config_path('laravel-news.php'),
        ], 'laravel-news');
    }
}
