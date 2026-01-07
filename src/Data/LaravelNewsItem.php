<?php

declare(strict_types=1);

namespace AchyutN\LaravelNews\Data;

use Illuminate\Support\Carbon;

/**
 * @phpstan-type LaravelNewsItemArray array{
 *     id: int,
 *     title: string,
 *     url: string,
 *     user_id: int,
 *     created_at: string,
 *     updated_at: string
 * }
 */
final class LaravelNewsItem
{
    public function __construct(
        public int $id,
        public string $title,
        public string $url,
        public int $userId,
        public Carbon $createdAt,
        public Carbon $updatedAt,
    ) {
        //
    }

    /**
     * Create DTO from API response data array
     *
     * @param  LaravelNewsItemArray  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            title: $data['title'],
            url: $data['url'],
            userId: (int) $data['user_id'],
            createdAt: Carbon::parse($data['created_at']),
            updatedAt: Carbon::parse($data['updated_at']),
        );
    }
}
