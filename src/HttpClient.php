<?php

declare(strict_types=1);

namespace JustSteveKing\HttpSlim;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Client\ClientExceptionInterface;
use JustSteveKing\HttpSlim\Exceptions\RequestError;

class HttpClient implements HttpClientInterface
{
    /**
     * @var ClientInterface
     */
    protected ClientInterface $client;

    /**
     * @var StreamFactoryInterface
     */
    protected StreamFactoryInterface $streamFactory;

    /**
     * @var RequestFactoryInterface
     */
    protected RequestFactoryInterface $requestFactory;

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
     * @param string $uri
     * @param array $body
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function post(string $uri, array $body): ResponseInterface
    {
        try {
            $content = $this->encodeJson($body);
            // @codeCoverageIgnoreStart
        } catch (\JsonException $exception) {
            throw RequestError::invalidJson($exception);
        }
        // @codeCoverageIgnoreEnd

        $request = $this->requestFactory->createRequest('POST', $uri)
            ->withAddedHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream($content));

        return $this->client->sendRequest($request);
    }

    /**
     * @param string $uri
     * @param array $body
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function put(string $uri, array $body): ResponseInterface
    {
        try {
            $content = $this->encodeJson($body);
            // @codeCoverageIgnoreStart
        } catch (\JsonException $exception) {
            throw RequestError::invalidJson($exception);
        }
        // @codeCoverageIgnoreEnd

        $request = $this->requestFactory->createRequest('PUT', $uri)
            ->withAddedHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream($content));

        return $this->client->sendRequest($request);
    }

    /**
     * @param string $uri
     * @param array $body
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function patch(string $uri, array $body): ResponseInterface
    {
        try {
            $content = $this->encodeJson($body);
            // @codeCoverageIgnoreStart
        } catch (\JsonException $exception) {
            throw RequestError::invalidJson($exception);
        }
        // @codeCoverageIgnoreEnd

        $request = $this->requestFactory->createRequest('PATCH', $uri)
            ->withAddedHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream($content));

        return $this->client->sendRequest($request);
    }

    /**
     * @param string $uri
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function get(string $uri): ResponseInterface
    {
        $request = $this->requestFactory->createRequest('GET', $uri)
            ->withAddedHeader('Content-Type', 'application/json');

        return $this->client->sendRequest($request);
    }

    /**
     * @param string $uri
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function delete(string $uri): ResponseInterface
    {
        $request = $this->requestFactory->createRequest('DELETE', $uri)
            ->withAddedHeader('Content-Type', 'application/json');

        return $this->client->sendRequest($request);
    }

    /**
     * @param array $json
     * @return string
     * @throws \JsonException
     */
    protected function encodeJson(array $json): string
    {
        return json_encode($json, JSON_THROW_ON_ERROR);
    }
}
