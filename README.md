## Laravel PackMe

A laravel command to generate a laravel starting package, it just provide a basic skeleton. It include a complete boilerplate code, just keep what you want remove the remaining.

## Installation

Install this package via composer

```bash
composer require rukhsar/laravel-packme
```

Then add the service provider to you provider's array in `config/app.php`

```php
    Rukhsar\PackMe\PackMeServiceProvider::class,
```

## Usage

It will create a packages directory, creates the vendor and package directory in it, pulls in a skeleton package, sets up composer.json, creates a service provider, registers the package in config/app.php and the app's composer.json. So you can start right away with only this command:

```bash
php artisan pack:me vendor_name package_name
```

This project is open-sourced software licensed under the [MIT](https://opensource.org/licenses/MIT) License.
