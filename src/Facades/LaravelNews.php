<?php

declare(strict_types=1);

namespace AchyutN\LaravelNews\Facades;

use AchyutN\LaravelNews\Data\Link;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Link post(Link $link)
 *
 * @see \AchyutN\LaravelNews\LaravelNews
 */
final class LaravelNews extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor(): string
    {
        return \AchyutN\LaravelNews\LaravelNews::class;
    }
}
