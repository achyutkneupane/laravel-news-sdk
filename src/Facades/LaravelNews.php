<?php

declare(strict_types=1);

namespace AchyutN\LaravelNews\Facades;

use Illuminate\Support\Facades\Facade;

final class LaravelNews extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \AchyutN\LaravelNews\LaravelNews::class;
    }
}
