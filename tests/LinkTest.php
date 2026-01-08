<?php

declare(strict_types=1);

use AchyutN\LaravelNews\Data\Link;
use AchyutN\LaravelNews\Enums\LinkCategory;
use AchyutN\LaravelNews\Exceptions\LaravelNewsException;
use Illuminate\Support\Carbon;

it('can be converted to an array', function () {
    $link = new Link(
        title: 'Laravel News',
        url: 'https://laravel-news.com',
        category: LinkCategory::Tutorial
    );

    expect($link->toPostArray())->toBe([
        'title' => 'Laravel News',
        'url' => 'https://laravel-news.com',
        'category' => 'Tutorial',
    ]);
});

it('can be instantiated from an array', function () {
    $link = Link::fromArray([
        'id' => 1,
        'title' => 'Laravel News',
        'url' => 'https://laravel-news.com',
        'user_id' => 42,
        'created_at' => '2026-01-08T16:00:00Z',
        'updated_at' => '2026-01-08T16:00:00Z',
    ]);

    expect($link->id)->toBe(1)
        ->and($link->title)->toBe('Laravel News')
        ->and($link->userId)->toBe(42)
        ->and($link->createdAt)->toBeInstanceOf(Carbon::class);
});

it('validates the title length', function () {
    new Link(title: str_repeat('a', 101), url: 'https://google.com');
})->throws(LaravelNewsException::class, 'Title is required and must be less than 100 characters.');

it('validates the url format', function () {
    new Link(title: 'Valid Title', url: 'not-a-url');
})->throws(LaravelNewsException::class, 'A valid URL is required.');
