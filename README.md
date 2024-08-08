# Eloquent Modelware for laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/inmanturbo/modelware.svg?style=flat-square)](https://packagist.org/packages/inmanturbo/modelware)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/inmanturbo/modelware/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/inmanturbo/modelware/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/inmanturbo/modelware/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/inmanturbo/modelware/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/inmanturbo/modelware.svg?style=flat-square)](https://packagist.org/packages/inmanturbo/modelware)

## Installation

You can install the package via composer:

```bash
composer require inmanturbo/modelware
```

## Usage

Add modelware in the boot method of a service provider

```php
use Inmanturbo\Modelware\Facades\Modelware;

Modelware::add(('eloquent.updating*', [
    EnsureModelShouldBeSaved::class,
    ValidateAttributes::class,
    FillModel::class,
], prefix: 'modelware'); // modelware is the default
```

This package sends the event data through pipelines (similiar to middleware), which iterate through collections of invokable classes, these collections are bound into and resolved from the service container using the following syntax:

```php
    app()->bind("{$prefix}.{$event}", function () use ($pipes) {
        return collect($pipes)->map(fn ($pipe) => app($pipe));
    });
```

Where the `{$event}` is a [wildcard event](https://laravel.com/docs/11.x/events#wildcard-event-listeners) for eloquent:

- `modelware.eloquent.creating*` => `eloquent.creating*`
- `modelware.eloquent.updating*` => `eloquent.updating*`
- `modelware.eloquent.deleting*` => `eloquent.deleting*`

This package will send the following data object through your custom pipeline:

```php
$data = app(Data::class, [
    'event' => $events,
    'model' => $payload[0],
    'payload' => $payload,
]);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [inmanturbo](https://github.com/inmanturbo)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
