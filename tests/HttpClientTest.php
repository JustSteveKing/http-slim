<?php

declare(strict_types=1);

namespace JustSteveKing\Tests\HttpSlim;

use JsonSerializable;
use JustSteveKing\HttpSlim\HttpClient;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Client\ClientInterface;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\HttpClient\Psr18Client;

class HttpClientTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @var string
     */
    private string $url = 'https://jsonplaceholder.typicode.com';

    /**
     * @var ObjectProphecy
     */
    private ObjectProphecy $client;

    /**
     * @var array
     */
    private array $body;

    protected function setUp(): void
    {
        $this->client = $this->prophesize(ClientInterface::class);

        $this->body = [];
    }

    public function testThatWeCanSendAPostRequest()
    {
        $this->body = [
            'foo' => 'bar'
        ];

        $psr18Client = new Psr18Client();

        $this->client->sendRequest(Argument::that(\Closure::fromCallable([$this, 'isRequestWithBodyExpected'])))
            ->shouldBeCalled()
            ->willReturn(new Response());

        $httpClient = HttpClient::build($this->client->reveal(), $psr18Client, $psr18Client);

        $httpClient->post($this->url, $this->body);
    }

    public function testThatWeCanSendAPostRequestWithAuthorization()
    {
        $this->body = [
            'foo' => 'bar'
        ];

        $psr18Client = new Psr18Client();

        $this->client
            ->sendRequest(Argument::that(\Closure::fromCallable([$this, 'isRequestWithBodyAndAuthorizationExpected'])))
            ->shouldBeCalled()
            ->willReturn(new Response());

        $httpClient = HttpClient::build($this->client->reveal(), $psr18Client, $psr18Client);

        $httpClient->post($this->url, $this->body, ['Authorization' => 'Basic dGVzdDp0ZXN0']);
    }

    public function testThatWeCanSendAGetRequest()
    {
        $psr18Client = new Psr18Client();

        $this->client->sendRequest(Argument::that(\Closure::fromCallable([$this, 'sendGetRequest'])))
            ->shouldBeCalled()
            ->willReturn(new Response());

        $httpClient = HttpClient::build($this->client->reveal(), $psr18Client, $psr18Client);

        $httpClient->get($this->url);
    }

    public function testThatWeCanSendAGetRequestWithAuthorization()
    {
        $psr18Client = new Psr18Client();

        $this->client
            ->sendRequest(Argument::that(\Closure::fromCallable([$this, 'sendGetRequestWithAuthorization'])))
            ->shouldBeCalled()
            ->willReturn(new Response());

        $httpClient = HttpClient::build($this->client->reveal(), $psr18Client, $psr18Client);

        $httpClient->get($this->url, ['Authorization' => 'Basic dGVzdDp0ZXN0']);
    }

    public function testThatWeCanSendADeleteRequest()
    {
        $psr18Client = new Psr18Client();

        $this->client->sendRequest(Argument::that(\Closure::fromCallable([$this, 'sendDeleteRequest'])))
            ->shouldBeCalled()
            ->willReturn(new Response());

        $httpClient = HttpClient::build($this->client->reveal(), $psr18Client, $psr18Client);

        $httpClient->delete($this->url);
    }

    public function testThatWeCanSendADeleteRequestWithAuthorization()
    {
        $psr18Client = new Psr18Client();

        $this->client
            ->sendRequest(Argument::that(\Closure::fromCallable([$this, 'sendDeleteRequestWithAuthorization'])))
            ->shouldBeCalled()
            ->willReturn(new Response());

        $httpClient = HttpClient::build($this->client->reveal(), $psr18Client, $psr18Client);

        $httpClient->delete($this->url, ['Authorization' => 'Basic dGVzdDp0ZXN0']);
    }

    public function testThatWeCanSendAPutRequest()
    {
        $this->body = [
            'foo' => 'bar'
        ];

        $psr18Client = new Psr18Client();

        $this->client->sendRequest(Argument::that(\Closure::fromCallable([$this, 'isRequestWithBodyExpected'])))
            ->shouldBeCalled()
            ->willReturn(new Response());

        $httpClient = HttpClient::build($this->client->reveal(), $psr18Client, $psr18Client);

        $httpClient->put($this->url, $this->body);
    }

    public function testThatWeCanSendAPutRequestWithAuthorization()
    {
        $this->body = [
            'foo' => 'bar'
        ];

        $psr18Client = new Psr18Client();

        $this->client
            ->sendRequest(Argument::that(\Closure::fromCallable([$this, 'isRequestWithBodyAndAuthorizationExpected'])))
            ->shouldBeCalled()
            ->willReturn(new Response());

        $httpClient = HttpClient::build($this->client->reveal(), $psr18Client, $psr18Client);

        $httpClient->put($this->url, $this->body, ['Authorization' => 'Basic dGVzdDp0ZXN0']);
    }

    public function testThatWeCanSendAPatchRequest()
    {
        $this->body = [
            'foo' => 'bar'
        ];

        $psr18Client = new Psr18Client();

        $this->client->sendRequest(Argument::that(\Closure::fromCallable([$this, 'isRequestWithBodyExpected'])))
            ->shouldBeCalled()
            ->willReturn(new Response());

        $httpClient = HttpClient::build($this->client->reveal(), $psr18Client, $psr18Client);

        $httpClient->patch($this->url, $this->body);
    }

    public function testThatWeCanSendAPatchRequestWithAuthorization()
    {
        $this->body = [
            'foo' => 'bar'
        ];

        $psr18Client = new Psr18Client();

        $this->client->sendRequest(Argument::that(\Closure::fromCallable([$this, 'isRequestWithBodyAndAuthorizationExpected'])))
            ->shouldBeCalled()
            ->willReturn(new Response());

        $httpClient = HttpClient::build($this->client->reveal(), $psr18Client, $psr18Client);

        $httpClient->patch($this->url, $this->body, ['Authorization' => 'Basic dGVzdDp0ZXN0']);
    }

    public function isRequestExpected(RequestInterface $request): bool
    {
        self::assertTrue($request->hasHeader('Content-Type'), 'Content-Type header not set');
        self::assertSame(
            'application/json',
            $request->getHeaderLine('Content-Type'),
            'Unexpected Content-Type header value'
        );

        self::assertSame('{"foo":"bar"}', $request->getBody()->getContents(), 'Unexpected body content');

        return true;
    }

    public function isRequestWithBodyExpected(RequestInterface $request): bool
    {
        self::assertTrue($request->hasHeader('Content-Type'), 'Content-Type header not set');
        self::assertSame(
            'application/json',
            $request->getHeaderLine('Content-Type'),
            'Unexpected Content-Type header value'
        );

        self::assertSame('{"foo":"bar"}', $request->getBody()->getContents(), 'Unexpected body content');

        return true;
    }

    public function isRequestWithBodyAndAuthorizationExpected(RequestInterface $request): bool
    {
        self::assertTrue($request->hasHeader('Content-Type'), 'Content-Type header not set');
        self::assertSame(
            'application/json',
            $request->getHeaderLine('Content-Type'),
            'Unexpected Content-Type header value'
        );

        self::assertTrue($request->hasHeader('Authorization'), 'Authorization header not set');
        self::assertSame(
            'Basic dGVzdDp0ZXN0',
            $request->getHeaderLine('Authorization'),
            'Unexpected Authorization header value'
        );

        self::assertSame('{"foo":"bar"}', $request->getBody()->getContents(), 'Unexpected body content');

        return true;
    }

    public function sendGetRequest(RequestInterface $request): bool
    {
        return true;
    }

    public function sendGetRequestWithAuthorization(RequestInterface $request): bool
    {
        self::assertTrue($request->hasHeader('Authorization'), 'Authorization header not set');
        self::assertSame(
            'Basic dGVzdDp0ZXN0',
            $request->getHeaderLine('Authorization'),
            'Unexpected Authorization header value'
        );

        return true;
    }

    public function sendDeleteRequest(RequestInterface $request): bool
    {
        return true;
    }

    public function sendDeleteRequestWithAuthorization(RequestInterface $request): bool
    {
        self::assertTrue($request->hasHeader('Authorization'), 'Authorization header not set');
        self::assertSame(
            'Basic dGVzdDp0ZXN0',
            $request->getHeaderLine('Authorization'),
            'Unexpected Authorization header value'
        );

        return true;
    }

    protected function getHttpClient(): HttpClient
    {
        $psr18Client = $requestFactory = $streamFactory = new Psr18Client();

        return HttpClient::build(
            $psr18Client,
            $requestFactory,
            $streamFactory
        );
    }
}
