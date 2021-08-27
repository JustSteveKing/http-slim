# Http Slim

<!-- BADGES_START -->
[![Latest Version][badge-release]][packagist]
[![Software License][badge-license]][license]
[![PHP Version][badge-php]][php]
![run-tests](https://github.com/JustSteveKing/http-slim/workflows/run-tests/badge.svg)
[![Total Downloads][badge-downloads]][downloads]

[badge-release]: https://img.shields.io/packagist/v/juststeveking/http-slim.svg?style=flat-square&label=release
[badge-license]: https://img.shields.io/packagist/l/juststeveking/http-slim.svg?style=flat-square
[badge-php]: https://img.shields.io/packagist/php-v/juststeveking/http-slim.svg?style=flat-square

[badge-downloads]: https://img.shields.io/packagist/dt/juststeveking/http-slim.svg?style=flat-square&colorB=mediumvioletred

[packagist]: https://packagist.org/packages/juststeveking/http-slim
[license]: https://github.com/JustSteveKing/http-slim/blob/master/LICENSE
[php]: https://php.net
[downloads]: https://packagist.org/packages/juststeveking/http-slim
<!-- BADGES_END -->

The purpose of this package is to create an interoperable http client implementation allowing a "bring you own packages" approach to connection to 3rd party services.

The main goal of this package is to adhere to the following PSRs:

- [PSR-18 - HTTP Client](https://www.php-fig.org/psr/psr-18/)
- [PSR-17 - HTTP Factories](https://www.php-fig.org/psr/psr-17/)
- [PSR-7 - HTTP Message Interface](https://www.php-fig.org/psr/psr-7/)


## Installation

Using composer:

```bash
$ composer require juststeveking/http-slim
```

You are then free to use it as needed within your projects.

## Next steps

The next step is to install a compliant package to do the request itself.

A few packages that are recommended:

- [Guzzle](http://docs.guzzlephp.org/en/stable/)
- [Symfony HttpClient](https://symfony.com/doc/current/components/http_client.html)
- [A great PSR implementation with factories to adhere to PSR-18 fully](https://github.com/Nyholm/psr7)


## Usage

Once you have installed a **PSR-18** package and a **PSR-17** package we do not _need_ to do anything else. This package support HTTP Autodiscovery for your PSR compliant Client and Request factories. However, should you choose to inject you can do!

```php
<?php

declare(strict_types=1);

use JustSteveKing\HttpSlim\HttpClient;
use Symfony\Component\HttpClient\Psr18Client;

// Injecting Clients: 
$httpClient = HttpClient::build(
    clientInterface: new Psr18Client(),
    requestFactory: new Psr18Client(),
    streamFactory: new Psr18Client(),
);

// Using HTTP Auto-discovery
$httpClient = HttpClient::build();


// perform a get request
$httpClient->get(
    uri: 'https://api.example.com/v1/resource',
);

// perform a post request
$httpClient->post(
    uri: 'https://api.example.com/v1/resource',
    body: ['foo' => 'bar'],
);

// perform a put request
$httpClient->put(
    uri: 'https://api.example.com/v1/resource/identifier',
    body: ['foo' => 'bar'],
);

// perform a patch request
$httpClient->patch(
    uri: 'https://api.example.com/v1/resource/identifier',
    body: ['foo' => 'bar'],
);

// perform a delete request
$httpClient->delete(
    uri: 'https://api.example.com/v1/resource/identifier',
);

// perform an options request
$httpClient->options(
    uri: 'https://api.example.com/v1/resource/identifier',
    headers: ['X-OPTIONAL' => 'headers'],
);

// Adding Plugins
$httpClient->addPlugin(
    plugin: new \Http\Client\Common\Plugin\HeaderDefaultsPlugin(
        headers: ['Content-Type' => 'application/json'],
    ),
);
```

## Tests

There is a composer script available to run the tests:

```bash
$ composer run preflight:test
```

However, if you are unable to run this please use the following command:

```bash
$ ./vendor/bin/phpunit --testdox
```

## Security

If you discover any security related issues, please email juststevemcd@gmail.com instead of using the issue tracker.
