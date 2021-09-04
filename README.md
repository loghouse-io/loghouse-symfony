# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/loghouse-io/loghouse-symfony.svg?style=flat-square)](https://packagist.org/packages/loghouse-io/loghouse-symfony)
[![Total Downloads](https://img.shields.io/packagist/dt/loghouse-io/loghouse-symfony.svg?style=flat-square)](https://packagist.org/packages/loghouse-io/loghouse-symfony)

LogHouse is a logging management system that allows you to store hundreds of gigabytes of logs with almost no configuration and with blazing fast ingestion and querying speed.
## Installation

You can install the package via composer:

```bash
composer require loghouse-io/loghouse-symfony
```

## Usage

1. You need to add 2 parameters to the .env file
```
LOGHOUSE_SYMFONY_ACCESS_TOKEN={LOGHOUSE_SYMFONY_ACCESS_TOKEN}
LOGHOUSE_SYMFONY_BUCKET_ID={LOGHOUSE_SYMFONY_BUCKET_ID}
```
2. You must register a new service in services.yaml
```php
#services.yaml
services:
    ...
    LoghouseIo\LoghouseSymfony\Handlers\LoghouseSymfonyHandler:
            arguments:
                $accessToken: '%env(LOGHOUSE_SYMFONY_ACCESS_TOKEN)%'
                $bucketId: '%env(LOGHOUSE_SYMFONY_BUCKET_ID)%'
```
3. And then set up a new handler in monolog.yaml
```php
#monolog.yaml
monolog:
    ...
    handlers:
        ...
        loghouse:
            type: service
            id: LoghouseIo\LoghouseSymfony\Handlers\LoghouseSymfonyHandler
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

## Credits

-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
