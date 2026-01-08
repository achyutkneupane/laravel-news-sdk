# Laravel News SDK

A simple PHP SDK for submitting links to [Laravel News](https://laravel-news.com) using their API.

## Requirements

- PHP 8.1 or higher
- Laravel 10.0 or higher

## Installation

You can install the package via Composer:

```sh
composer require achyutn/laravel-news-sdk
```

## Configuration

After installing, publish the configuration file:

```sh
php artisan vendor:publish --tag="laravel-news"
```

This will create a `config/laravel-news.php` file.

Next, set your Laravel News API token in your `.env` file:

```sh
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
    title: 'Filament Log Viewer',
    url: 'https://packagist.org/packages/achyutn/filament-log-viewer',
    category: LinkCategory::Package
);

$item = LaravelNews::post($link);

// The item is a Link DTO populated with server-side data
echo $item->id;
echo $item->createdAt;
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
        $link = new Link(
            title: 'Cool Tutorial',
            url: 'https://example.com/tutorial'
        );

        $item = $this->laravelNews->post($link);
    }
}
```

## API Reference

### LaravelNews

The main class for interacting with the Laravel News API.

#### `post(Link $link): Link`

Submits a link and returns a populated Link instance.

- **Throws**: `AchyutN\LaravelNews\Exceptions\LaravelNewsException` if the API returns an error or the token is missing.

### Link

The core Data Transfer Object for submitting links.

Properties:

- `string $title` (Required, max 100 chars)
- `string $url` (Required, valid URL)
- `LinkCategory|null $category`
- `int|null $id` (Populated after response)
- `int|null $userId` (Populated after response)
- `Carbon|null $createdAt`
- `Carbon|null $updatedAt`

#### `toPostArray(): array`

Converts the DTO into the format expected by the Laravel News API for submission.

#### `fromArray(array $data): self`

Creates a `Link` item from API response data.

### LinkCategory

Enum for link categories.

- `LinkCategory::Tutorial`
- `LinkCategory::Package`

## Contributing

Contributions are welcome! Please create a pull request or open an issue if you find any bugs or have feature requests.

## License

This package is open-sourced software licensed under the [MIT license](LICENSE.md).

## Support

If you find this package useful, please consider starring the repository on GitHub to show your support.
