<?php

declare(strict_types=1);

namespace AchyutN\LaravelNews\Data;

use AchyutN\LaravelNews\Enums\LinkCategory;

/**
 * @phpstan-type LinkArray array{
 *     title: string,
 *     url: string,
 *     category: string
 * }
 */
final class Link
{
    public function __construct(
        public string $title,
        public string $url,
        public LinkCategory $category
    ) {
        //
    }

    /** @return LinkArray */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'url' => $this->url,
            'category' => $this->category->value,
        ];
    }
}
