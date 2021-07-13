<?php

namespace JustSteveKing\Tests\HttpSlim\Concerns;

use JustSteveKing\HttpSlim\HttpClient;
use Nyholm\Psr7\Response;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\HttpClient\Psr18Client;

trait TestsHttpClient
{
    use ProphecyTrait;

    public string $url = 'https://jsonplaceholder.typicode.com';
    public array $body = [];
    public ObjectProphecy $client;

    public function body(array $content = []): void
    {
        $this->body = $content;
    }

    public function expectRequest(callable|bool $expectation = true): void
    {
        if ($expectation === true) {
            expect($expectation)->toBeTrue(); // Add to the assertion count
        }

        $this->client
            ->sendRequest(Argument::that(fn($request) => is_callable($expectation) ? $expectation(expect($request)) : $expectation))
            ->shouldBeCalled()
            ->willReturn(new Response());
    }

    public function http($client = null)
    {
        $psr18Client = new Psr18Client();
        return HttpClient::build($client ?? $psr18Client, $psr18Client, $psr18Client);
    }

    public function get(array $headers = [])
    {
        return $this->http($this->client->reveal())->get($this->url, $headers);
    }

    public function post(array $headers = [])
    {
        return $this->http($this->client->reveal())->post($this->url, $this->body, $headers);
    }

    public function delete(array $headers = [])
    {
        return $this->http($this->client->reveal())->delete($this->url, $headers);
    }

    public function put(array $headers = [])
    {
        return $this->http($this->client->reveal())->put($this->url, $this->body, $headers);
    }

    public function patch(array $headers = [])
    {
        return $this->http($this->client->reveal())->patch($this->url, $this->body, $headers);
    }

    public function options(array $headers = [])
    {
        return $this->http($this->client->reveal())->options($this->url, $headers);
    }
}
