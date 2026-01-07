<?php

declare(strict_types=1);

use AchyutN\LaravelNews\Data\Link;
use AchyutN\LaravelNews\Enums\LinkCategory;
use AchyutN\LaravelNews\Exceptions\LaravelNewsException;

it('has correct enum values', function () {
    expect(LinkCategory::Tutorial->value)->toBe('Tutorial');
    expect(LinkCategory::Package->value)->toBe('Package');
});

it('converts link DTO to array', function () {
    $link = new Link(
        title: 'Test Title',
        url: 'https://achyut.com.np',
        category: LinkCategory::Tutorial
    );

    expect($link->toArray())->toBe([
        'title' => 'Test Title',
        'url' => 'https://achyut.com.np',
        'category' => LinkCategory::Tutorial->value,
    ]);
});

it('throws exception for invalid category', function () {
    $this->expectException(TypeError::class);

    new Link(
        title: 'Test Title',
        url: 'https://achyut.com.np',
        category: 'InvalidCategory'
    );
});

it('throws exception for title with length greater than 100', function () {
    $this->expectException(LaravelNewsException::class);

    new Link(
        title: str_repeat('A', 101),
        url: 'https://achyut.com.np',
        category: LinkCategory::Tutorial
    );
});

it('throws exception for empty title', function () {
    $this->expectException(LaravelNewsException::class);

    new Link(
        title: '',
        url: 'https://achyut.com.np',
        category: LinkCategory::Tutorial
    );
});

it('throws exception for invalid URL', function () {
    $this->expectException(LaravelNewsException::class);

    new Link(
        title: 'Test Title',
        url: 'invalid-url',
        category: LinkCategory::Tutorial
    );
});
