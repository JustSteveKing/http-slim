<?php

declare(strict_types=1);

namespace JustSteveKing\HttpSlim;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Client\ClientExceptionInterface;

use function Safe\json_encode;

class HttpClient implements HttpClientInterface
{
    /**
     * @var array
     */
    private array $defaultHeaders = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json'
    ];

    /**
     * HttpClient constructor.
     *
     * @param ClientInterface $client
     * @param RequestFactoryInterface $requestFactory
     * @param StreamFactoryInterface $streamFactory
     *
     * @return void
     */
    final protected function __construct(
        private ClientInterface $client,
        private RequestFactoryInterface $requestFactory,
        private StreamFactoryInterface $streamFactory
    ) {
    }

    /**
     * Build a new instance of HttpClient
     *
     * @param ClientInterface $client
     * @param RequestFactoryInterface $requestFactory
     * @param StreamFactoryInterface $streamFactory
     *
     * @return HttpClient
     */
    public static function build(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory
    ): HttpClient {
        return new HttpClient(
            client: $client,
            requestFactory: $requestFactory,
            streamFactory: $streamFactory,
        );
    }

    /**
     * Get the instance of the injected client
     *
     * @return ClientInterface
     */
    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    /**
     * Send a GET request.
     *
     * @param string $uri
     * @param array $headers
     *
     * @return ResponseInterface
     *
     * @throws ClientExceptionInterface
     */
    public function get(string $uri, array $headers = []): ResponseInterface
    {
        $request = $this->requestFactory->createRequest(
            method: Request::GET,
            uri: $uri
        );

        foreach (array_merge($this->defaultHeaders, $headers) as $name => $value) {
            // ommiting named args here as some libraries use a different naming convention.
            $request = $request->withHeader(
                $name,
                $value,
            );
        }

        return $this->client->sendRequest(
            request: $request,
        );
    }

    /**
     * @param string $uri
     * @param array $body
     * @param array $headers
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function post(string $uri, array $body, array $headers = []): ResponseInterface
    {
        $request = $this->requestFactory->createRequest(
            method: Request::POST,
            uri: $uri
        )->withBody(
            body: $this->streamFactory->createStream(
                content: json_encode($body),
            ),
        );

        foreach (array_merge($this->defaultHeaders, $headers) as $name => $value) {
            // ommiting named args here as some libraries use a different naming convention.
            $request = $request->withHeader(
                $name,
                $value,
            );
        }

        return $this->client->sendRequest(
            request: $request,
        );
    }

    /**
     * @param string $uri
     * @param array $body
     * @param array $headers
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function put(string $uri, array $body, array $headers = []): ResponseInterface
    {
        $request = $this->requestFactory->createRequest(
            method: Request::PUT,
            uri: $uri
        )->withBody(
            body: $this->streamFactory->createStream(
                content: json_encode($body),
            ),
        );

        foreach (array_merge($this->defaultHeaders, $headers) as $name => $value) {
            // ommiting named args here as some libraries use a different naming convention.
            $request = $request->withHeader(
                $name,
                $value,
            );
        }

        return $this->client->sendRequest(
            request: $request,
        );
    }

    /**
     * @param string $uri
     * @param array $body
     * @param array $headers
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function patch(string $uri, array $body, array $headers = []): ResponseInterface
    {
        $request = $this->requestFactory->createRequest(
            method: Request::PATCH,
            uri: $uri
        )->withBody(
            body: $this->streamFactory->createStream(
                content: json_encode($body),
            ),
        );

        foreach (array_merge($this->defaultHeaders, $headers) as $name => $value) {
            // ommiting named args here as some libraries use a different naming convention.
            $request = $request->withHeader(
                $name,
                $value,
            );
        }

        return $this->client->sendRequest(
            request: $request,
        );
    }

    /**
     * @param string $uri
     * @param array $headers
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function delete(string $uri, array $headers = []): ResponseInterface
    {
        $request = $this->requestFactory->createRequest(
            method: Request::DELETE,
            uri: $uri
        );

        foreach (array_merge($this->defaultHeaders, $headers) as $name => $value) {
            // ommiting named args here as some libraries use a different naming convention.
            $request = $request->withHeader(
                $name,
                $value,
            );
        }

        return $this->client->sendRequest(
            request: $request,
        );
    }

    /**
     * @param string $uri
     * @param array $headers
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function options(string $uri, array $headers = []): ResponseInterface
    {
        $request = $this->requestFactory->createRequest(
            method: Request::OPTIONS,
            uri: $uri
        );

        foreach (array_merge($this->defaultHeaders, $headers) as $name => $value) {
            // ommiting named args here as some libraries use a different naming convention.
            $request = $request->withHeader(
                $name,
                $value,
            );
        }

        return $this->client->sendRequest(
            request: $request,
        );
    }
}
