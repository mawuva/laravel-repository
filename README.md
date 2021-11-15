# Repository Pattern implementation for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mawuekom/laravel-repository.svg?style=flat-square)](https://packagist.org/packages/mawuekom/laravel-repository)
[![Total Downloads](https://img.shields.io/packagist/dt/mawuekom/laravel-repository.svg?style=flat-square)](https://packagist.org/packages/mawuekom/laravel-repository)

This is a Simple Repository Pattern implementation for Laravel Projects and 
an easily way to build Eloquent queries from API requests.

## Installation

You can install the package via composer:

```bash
composer require mawuekom/laravel-repository
```

## configuration

### Laravel <br/>

After register the service provider to the **`providers`** array in **`config/app.php`**

```php
'providers' =>
    ...
    Mawuekom\Repository\RepositoryServiceProvider::class
    ...
];
```
<br/>

Publish package config

```bash
php artisan vendor:publish --provider="Mawuekom\Repository\RepositoryServiceProvider"
```

### Lumen <br/>

Go to **`bootstrap/app.php`**, and add this in the specified key

```php
$app->register(Mawuekom\Repository\RepositoryServiceProvider::class);

```

## Usage

```php
// Coming soon
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### **Hope this package will help you build awesome things** <br><br>

## Report bug
Contact me on Twitter [@ephraimseddor](https://twitter.com/ephraimseddor)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
