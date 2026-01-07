<?php

declare(strict_types=1);

use AchyutN\LaravelNews\Data\LaravelNewsItem;
use Illuminate\Support\Carbon;

it('creates a LaravelNewsItem from array', function () {
    $data = [
        'id' => 1,
        'title' => 'Test Title',
        'url' => 'https://achyut.com.np',
        'user_id' => 1,
        'created_at' => '2026-01-07T13:53:56.000000Z',
        'updated_at' => '2026-01-07T13:53:56.000000Z',
    ];

    $item = LaravelNewsItem::fromArray($data);

    expect($item->id)->toBe(1);
    expect($item->title)->toBe($data['title']);
    expect($item->url)->toBe($data['url']);
    expect($item->userId)->toBe(1);

    expect($item->createdAt)->toBeInstanceOf(Carbon::class)
        ->and($item->createdAt->toIso8601String())->toBe('2026-01-07T13:53:56+00:00');

    expect($item->updatedAt)->toBeInstanceOf(Carbon::class)
        ->and($item->updatedAt->toIso8601String())->toBe('2026-01-07T13:53:56+00:00');
});
