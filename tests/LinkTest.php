<?php

declare(strict_types=1);

use AchyutN\LaravelNews\Data\Link;
use AchyutN\LaravelNews\Enums\LinkCategory;
use AchyutN\LaravelNews\Exceptions\LaravelNewsException;
use Illuminate\Support\Carbon;

it('has correct enum values', function () {
    expect(LinkCategory::Tutorial->value)->toBe('Tutorial');
    expect(LinkCategory::Package->value)->toBe('Package');
});

it('converts link DTO to array for API request', function () {
    $link = new Link(
        title: 'Test Title',
        url: 'https://achyut.com.np',
        category: LinkCategory::Tutorial
    );

    expect($link->toPostArray())->toBe([
        'title' => 'Test Title',
        'url' => 'https://achyut.com.np',
        'category' => LinkCategory::Tutorial->value,
    ]);
});

it('creates a Link DTO from API response array', function () {
    $data = [
        'id' => 1,
        'title' => 'Test Title',
        'url' => 'https://achyut.com.np',
        'user_id' => 1,
        'created_at' => '2026-01-07T13:53:56.000000Z',
        'updated_at' => '2026-01-07T13:53:56.000000Z',
    ];

    $item = Link::fromArray($data);

    expect($item->id)->toBe(1)
        ->and($item->title)->toBe($data['title'])
        ->and($item->userId)->toBe(1)
        ->and($item->createdAt)->toBeInstanceOf(Carbon::class)
        ->and($item->createdAt->toIso8601String())->toBe('2026-01-07T13:53:56+00:00');
});

it('throws exception for title with length greater than 100', function () {
    $this->expectException(LaravelNewsException::class);
    new Link(title: str_repeat('A', 101), url: 'https://achyut.com.np');
});

it('throws exception for invalid URL', function () {
    $this->expectException(LaravelNewsException::class);
    new Link(title: 'Test Title', url: 'invalid-url');
});
