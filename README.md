# Http Slim

<!-- BADGES_START -->
[![Latest Version][badge-release]][packagist]
[![Software License][badge-license]][license]
[![PHP Version][badge-php]][php]
![run-tests](https://github.com/JustSteveKing/http-slim/workflows/run-tests/badge.svg)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/JustSteveKing/http-slim/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/JustSteveKing/http-slim/?branch=master)
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

THe main goal of this package is to adhere to the following PSRs:

- PSR-18
- PSR-17
- PSR-7


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


## Usage

Once you have a client to inject, you can set up an easy to use and consistent implementation. The following example is using the Symfony HttpClient as it has the best documentation I have seen so far.


```php
<?php

declare(strict_types=1);

use JustSteveKing\HttpSlim\HttpClient;
use Symfony\Component\HttpClient\Psr18Client;

$httpClient = HttpClient::build(
    new Psr18Client(), // our client
    new Psr18Client(), // our request factory
    new Psr18Client() // our stream factory
);

// perform a get request
$httpClient->get('https://api.example.com/v1/resource');


// perform a post request
$httpClient->post(
    'https://api.example.com/v1/resource',
    ['foo' => 'bar']
);

// perform a put request
$httpClient->put(
    'https://api.example.com/v1/resource/identifier',
    ['foo' => 'bar']
);

// perform a patch request
$httpClient->patch(
    'https://api.example.com/v1/resource/identifier',
    ['foo' => 'bar']
);

// perform a delete request
$httpClient->delete(
    'https://api.example.com/v1/resource/identifier'
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