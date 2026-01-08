<?php

declare(strict_types=1);

namespace AchyutN\LaravelNews\Data;

use AchyutN\LaravelNews\Enums\LinkCategory;
use AchyutN\LaravelNews\Exceptions\LaravelNewsException;
use Illuminate\Support\Carbon;

/**
 * @phpstan-type LinkArray array{
 * id?: int|null,
 * title: string,
 * url: string,
 * category?: string|null,
 * user_id?: int|null,
 * created_at?: string|null,
 * updated_at?: string|null
 * }
 */
final class Link
{
    /**
     * Create a new Link instance.
     */
    public function __construct(
        public string $title,
        public string $url,
        public ?LinkCategory $category = null,
        public ?int $id = null,
        public ?int $userId = null,
        public ?Carbon $createdAt = null,
        public ?Carbon $updatedAt = null,
    ) {
        $this->validate();
    }

    /**
     * Create a DTO instance from the given array.
     *
     * @param  LinkArray  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            url: $data['url'],
            category: isset($data['category']) ? LinkCategory::from($data['category']) : null,
            id: $data['id'] ?? null,
            userId: $data['user_id'] ?? null,
            createdAt: isset($data['created_at']) ? Carbon::parse($data['created_at']) : null,
            updatedAt: isset($data['updated_at']) ? Carbon::parse($data['updated_at']) : null,
        );
    }

    /**
     * Get the instance as an array for the API.
     *
     * @return array<string, mixed>
     */
    public function toPostArray(): array
    {
        return [
            'title' => $this->title,
            'url' => $this->url,
            'category' => $this->category?->value,
        ];
    }

    /**
     * Validate the DTO state.
     */
    private function validate(): void
    {
        if (trim($this->title) === '' || mb_strlen($this->title) > 100) {
            throw new LaravelNewsException('Title is required and must be less than 100 characters.');
        }

        if (! filter_var($this->url, FILTER_VALIDATE_URL)) {
            throw new LaravelNewsException('A valid URL is required.');
        }
    }
}
