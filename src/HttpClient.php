<?php

declare(strict_types=1);

namespace JustSteveKing\HttpSlim;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Client\ClientExceptionInterface;
use JustSteveKing\HttpSlim\Exceptions\RequestError;

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
     * @var ClientInterface
     */
    private ClientInterface $client;

    /**
     * @var StreamFactoryInterface
     */
    private StreamFactoryInterface $streamFactory;

    /**
     * @var RequestFactoryInterface
     */
    private RequestFactoryInterface $requestFactory;

    /**
     * HttpClient constructor.
     * @param ClientInterface $client
     * @param RequestFactoryInterface $requestFactory
     * @param StreamFactoryInterface $streamFactory
     */
    final protected function __construct(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory
    ) {
        $this->client = $client;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
    }

    /**
     * @param ClientInterface $client
     * @param RequestFactoryInterface $requestFactory
     * @param StreamFactoryInterface $streamFactory
     * @return static
     */
    public static function build(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory
    ): self {
        return new self(
            $client,
            $requestFactory,
            $streamFactory
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
     * @param string $uri
     * @param array $headers
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function get(string $uri, array $headers = []): ResponseInterface
    {
        $request = $this->createRequest('GET', $uri);

        foreach (array_merge($this->defaultHeaders, $headers) as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        return $this->client->sendRequest($request);
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
        try {
            $content = $this->encodeJson($body);
            // @codeCoverageIgnoreStart
        } catch (\JsonException $exception) {
            throw RequestError::invalidJson($exception);
        }
        // @codeCoverageIgnoreEnd

        $request = $this->createRequest('POST', $uri)
            ->withBody($this->streamFactory->createStream($content));

        foreach (array_merge($this->defaultHeaders, $headers) as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        return $this->client->sendRequest($request);
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
        try {
            $content = $this->encodeJson($body);
            // @codeCoverageIgnoreStart
        } catch (\JsonException $exception) {
            throw RequestError::invalidJson($exception);
        }
        // @codeCoverageIgnoreEnd

        $request = $this->createRequest('PUT', $uri)
            ->withBody($this->streamFactory->createStream($content));

        foreach (array_merge($this->defaultHeaders, $headers) as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        return $this->client->sendRequest($request);
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
        try {
            $content = $this->encodeJson($body);
            // @codeCoverageIgnoreStart
        } catch (\JsonException $exception) {
            throw RequestError::invalidJson($exception);
        }
        // @codeCoverageIgnoreEnd

        $request = $this->createRequest('PATCH', $uri)
            ->withBody($this->streamFactory->createStream($content));

        foreach (array_merge($this->defaultHeaders, $headers) as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        return $this->client->sendRequest($request);
    }

    /**
     * @param string $uri
     * @param array $headers
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function delete(string $uri, array $headers = []): ResponseInterface
    {
        $request = $this->createRequest('DELETE', $uri);

        foreach (array_merge($this->defaultHeaders, $headers) as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        return $this->client->sendRequest($request);
    }

    /**
     * @param string $uri
     * @param array $headers
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function options(string $uri, array $headers = []): ResponseInterface
    {
        $request = $this->createRequest('OPTIONS', $uri);

        foreach (array_merge($this->defaultHeaders, $headers) as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        return $this->client->sendRequest($request);
    }

    /**
     * @param array $json
     * @return string
     * @throws \JsonException
     */
    private function encodeJson(array $json): string
    {
        return json_encode($json, JSON_THROW_ON_ERROR);
    }

    /**
     * Create a new Request to send
     *
     * @param string $method
     * @param $uri
     * @return RequestInterface
     */
    private function createRequest(string $method, $uri): RequestInterface
    {
        return $this->requestFactory->createRequest(
            $method,
            $uri
        );
    }
}
