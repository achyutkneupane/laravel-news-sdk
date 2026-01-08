<?php

declare(strict_types=1);

namespace AchyutN\LaravelNews\Data;

use AchyutN\LaravelNews\Enums\LinkCategory;
use AchyutN\LaravelNews\Exceptions\LaravelNewsException;
use Illuminate\Support\Carbon;

/**
 * @phpstan-type LinkArray array{
 * id?: int,
 * title: string,
 * url: string,
 * category?: string,
 * user_id?: int,
 * created_at?: string,
 * updated_at?: string
 * }
 */
final class Link
{
    public function __construct(
        public string $title,
        public string $url,
        public ?LinkCategory $category = null,
        public ?int $id = null,
        public ?int $userId = null,
        public ?Carbon $createdAt = null,
        public ?Carbon $updatedAt = null,
    ) {
        if ($this->title === '' || $this->title === '0' || mb_strlen($this->title) > 100) {
            throw new LaravelNewsException('Title is required and must be less than 100 characters.');
        }

        if ($this->url === '' || $this->url === '0' || ! filter_var($this->url, FILTER_VALIDATE_URL)) {
            throw new LaravelNewsException('A valid URL is required.');
        }
    }

    /**
     * Create DTO from API response data array
     *
     * @param  LinkArray  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            url: $data['url'],
            category: isset($data['category']) ? LinkCategory::from($data['category']) : null,
            id: isset($data['id']) ? (int) $data['id'] : null,
            userId: isset($data['user_id']) ? (int) $data['user_id'] : null,
            createdAt: isset($data['created_at']) ? Carbon::parse($data['created_at']) : null,
            updatedAt: isset($data['updated_at']) ? Carbon::parse($data['updated_at']) : null,
        );
    }

    /**
     * @return array{title: string, url: string, category: string|null}
     */
    public function toPostArray(): array
    {
        return [
            'title' => $this->title,
            'url' => $this->url,
            'category' => $this->category?->value,
        ];
    }
}
