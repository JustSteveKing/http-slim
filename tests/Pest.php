<?php

declare(strict_types=1);
use JustSteveKing\Tests\HttpSlim\Concerns\TestsHttpClient;
use Psr\Http\Client\ClientInterface;

uses(TestsHttpClient::class)
    ->beforeEach(fn() => $this->client = $this->prophesize(ClientInterface::class))
    ->in(__DIR__);

expect()->extend('toHaveBody', function($body) {
    return $this
        ->hasHeader('Content-Type')->toBeTrue()
        ->getHeaderLine('Content-Type')->toBe('application/json')
        ->getBody()->getContents()->json()->toBe($body)
        ->and($this->value);
});

expect()->extend('toHaveAuthorization', function() {
    return $this
        ->hasHeader('Authorization')->toBeTrue()
        ->getHeaderLine('Authorization')->toBe('Basic dGVzdDp0ZXN0')
        ->and($this->value);
});
