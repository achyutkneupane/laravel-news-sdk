# Laravel News SDK

A simple PHP SDK for submitting links to [Laravel News](https://laravel-news.com) using their API.

## Requirements

- PHP 8.1 or higher
- Laravel 10.0 or higher

## Installation

You can install the package via Composer:

```bash
composer require achyutn/laravel-news-sdk
```

## Configuration

After installing, publish the configuration file:

```bash
php artisan vendor:publish --tag="laravel-news"
```

This will create a `config/laravel-news.php` file.

Next, set your Laravel News API token in your `.env` file:

```env
LARAVEL_NEWS_TOKEN=your-api-token-here
```

You can obtain an API token from [Laravel News](https://laravel-news.com/user/api-tokens).

## Usage

### Using the Facade

```php
use AchyutN\LaravelNews\Facades\LaravelNews;
use AchyutN\LaravelNews\Data\Link;
use AchyutN\LaravelNews\Enums\LinkCategory;

$link = new Link(
    title: 'My Awesome Package',
    url: 'https://github.com/achyutn/my-package',
    category: LinkCategory::Package
);

$item = LaravelNews::post($link);

// $item is a LaravelNewsItem with id, title, url, userId, createdAt, updatedAt
```

### Using Dependency Injection

```php
use AchyutN\LaravelNews\LaravelNews;

class SomeController
{
    public function __construct(
        private LaravelNews $laravelNews
    ) {}

    public function submitLink()
    {
        // ... create $link ...

        $item = $this->laravelNews->post($link);
    }
}
```

## API Reference

### LaravelNews

The main class for interacting with the Laravel News API.

#### `post(Link $link): LaravelNewsItem`

Submits a link to Laravel News.

- **Parameters**: `Link $link` - The link data to submit
- **Returns**: `LaravelNewsItem` - The created item from the API
- **Throws**: `LaravelNewsException` - On API errors or network issues

### Link

Data Transfer Object for link submissions.

```php
new Link(
    string $title,
    string $url,
    LinkCategory $category
);
```

#### `toArray(): array`

Converts the Link to an array for API submission.

### LinkCategory

Enum for link categories.

- `LinkCategory::Tutorial`
- `LinkCategory::Package`

### LaravelNewsItem

Data Transfer Object for API responses.

Properties:
- `int $id`
- `string $title`
- `string $url`
- `int $userId`
- `Carbon $createdAt`
- `Carbon $updatedAt`

#### `fromArray(array $data): self`

Creates a LaravelNewsItem from API response data.

## Contributing

Contributions are welcome! Please create a pull request or open an issue if you find any bugs or have feature requests.

## License

This package is open-sourced software licensed under the [MIT license](LICENSE.md).

## Support

If you find this package useful, please consider starring the repository on GitHub to show your support.
