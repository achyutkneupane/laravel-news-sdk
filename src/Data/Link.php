<?php

declare(strict_types=1);

namespace AchyutN\LaravelNews\Data;

use AchyutN\LaravelNews\Enums\LinkCategory;
use AchyutN\LaravelNews\Exceptions\LaravelNewsException;

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
        if ($this->title === '' || $this->title === '0' || mb_strlen($this->title) > 100) {
            throw new LaravelNewsException('Title is required and must be less than 100 characters.');
        }

        if ($this->url === '' || $this->url === '0' || ! filter_var($this->url, FILTER_VALIDATE_URL)) {
            throw new LaravelNewsException('A valid URL is required.');
        }
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
