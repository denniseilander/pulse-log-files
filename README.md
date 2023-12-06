# Laravel Pulse - Log Files

[![Latest Version on Packagist](https://img.shields.io/packagist/v/denniseilander/pulse-log-files.svg?style=flat-square)](https://packagist.org/packages/denniseilander/pulse-log-files)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/denniseilander/pulse-log-files/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/denniseilander/pulse-log-files/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/denniseilander/pulse-log-files/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/denniseilander/pulse-log-files/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/denniseilander/pulse-log-files.svg?style=flat-square)](https://packagist.org/packages/denniseilander/pulse-log-files)

A lightweight Laravel Pulse package for effortlessly viewing available log files in your current project.

<img width="1280" alt="pulse-log-files" src="https://github.com/denniseilander/pulse-log-files/assets/3907144/f39b0004-1338-4234-9bf0-c0ec95abcb64">


## Installation

You can install the package via composer:

```bash
composer require denniseilander/pulse-log-files
```

## Register the recorder

To let Laravel Pulse check the available log files, you need to register the recorder in the `config/pulse.php` file.

```php
return [
    ...
    
    'recorders' => [
        \Denniseilander\LogFiles\Recorders\LogFiles::class => [],
    ],
];
```

### Change the interval (optional)
By default, the recorder will be **checked once every 5 minutes**.  
You can change this by adding the `run_every_seconds` key to the array.

```php
'recorders' => [
    \Denniseilander\LogFiles\Recorders\LogFiles::class => [
        'run_every_seconds' => 10 * 60, // 10 minutes
    ],
],
```
Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="pulse-log-files-views"
```

## Usage

You can use the component in your views like this:
```html
<livewire:pulse.log-files cols="4" />
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

- [Dennis Eilander](https://github.com/denniseilander)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
