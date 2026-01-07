<?php

declare(strict_types=1);

namespace AchyutN\LaravelNews\Data;

/**
 * @phpstan-type LinkDTO array{
 *     title: string,
 *     url: string,
 *     category: string
 *  }
 */
final class Link
{
    public function __construct(
        public string $title,
        public string $url,
        public string $category
    ) {
        //
    }

    /** @return LinkDTO */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'url' => $this->url,
            'category' => $this->category,
        ];
    }
}
