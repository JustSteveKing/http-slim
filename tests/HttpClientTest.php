<?php

use Psr\Http\Client\ClientInterface;

it('can send a POST request')
    ->body(['foo' => 'bar'])
    ->expectRequest(fn($request) => $request->toHaveBody(['foo' => 'bar']))
    ->post();

it('can send a POST request with authorization')
    ->body(['foo' => 'bar'])
    ->expectRequest(fn($request) => $request->toHaveBody(['foo' => 'bar'])->toHaveAuthorization)
    ->post(['Authorization' => 'Basic dGVzdDp0ZXN0']);

it('can send a GET request')
    ->expectRequest()
    ->get();

it('can send a GET request with authorization')
    ->expectRequest(fn($request) => $request->toHaveAuthorization)
    ->post(['Authorization' => 'Basic dGVzdDp0ZXN0']);

it('can send a DELETE request')
    ->expectRequest()
    ->delete();

it('can send a DELETE request with authorization')
    ->expectRequest(fn($request) => $request->toHaveAuthorization)
    ->delete(['Authorization' => 'Basic dGVzdDp0ZXN0']);

it('can send a PUT request')
    ->body(['foo' => 'bar'])
    ->expectRequest(fn($request) => $request->toHaveBody(['foo' => 'bar']))
    ->put();

it('can send a PUT request with authorization')
    ->body(['foo' => 'bar'])
    ->expectRequest(fn($request) => $request->toHaveBody(['foo' => 'bar'])->toHaveAuthorization)
    ->put(['Authorization' => 'Basic dGVzdDp0ZXN0']);

it('can send a PATCH request')
    ->body(['foo' => 'bar'])
    ->expectRequest(fn($request) => $request->toHaveBody(['foo' => 'bar']))
    ->patch();

it('can send a PATCH request with authorization')
    ->body(['foo' => 'bar'])
    ->expectRequest(fn($request) => $request->toHaveBody(['foo' => 'bar'])->toHaveAuthorization)
    ->patch(['Authorization' => 'Basic dGVzdDp0ZXN0']);

it('can send an OPTIONS request')
    ->expectRequest()
    ->options();

it('can send an OPTIONS request with authorization')
    ->expectRequest(fn($request) => $request->toHaveAuthorization)
    ->options(['Authorization' => 'Basic dGVzdDp0ZXN0']);

it('can get an instance of the passed in client')
    ->expect(fn() => $this->http()->getClient())->toBeInstanceOf(ClientInterface::class);

it('can manage plugins', function () {
    $client = $this->http();
    expect($client->plugins())
        ->toBeEmpty();

    $client->addPlugin(
        plugin: new \Http\Client\Common\Plugin\HeaderDefaultsPlugin(
            headers: ['Accept' => 'application/json'],
        ),
    );

    expect($client->plugins())
        ->toBeArray()
        ->toHaveCount(1);
});
