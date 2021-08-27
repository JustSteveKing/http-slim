<?php

declare(strict_types=1);

namespace JustSteveKing\HttpSlim;

use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\Plugin;
use Http\Client\Common\PluginClientFactory;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Throwable;

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
     * @var array
     */
    private array $plugins = [];

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
    ) {}

    /**
     * Build a new instance of HttpClient
     *
     * @param null|ClientInterface $client
     * @param null|RequestFactoryInterface $requestFactory
     * @param null|StreamFactoryInterface $streamFactory
     *
     * @return HttpClient
     */
    public static function build(
        null|ClientInterface $client = null,
        null|RequestFactoryInterface $requestFactory = null,
        null|StreamFactoryInterface $streamFactory = null,
    ): HttpClient {
        return new HttpClient(
            client: $client ?? HttpClientDiscovery::find(),
            requestFactory: $requestFactory ?? Psr17FactoryDiscovery::findRequestFactory(),
            streamFactory: $streamFactory ?? Psr17FactoryDiscovery::findStreamFactory(),
        );
    }

    /**
     * Get the instance of the injected client
     *
     * @return ClientInterface
     */
    public function getClient(): ClientInterface
    {
        $pluginClient = (new PluginClientFactory())->createClient(
            client: $this->client,
            plugins: $this->plugins,
        );

        return new HttpMethodsClient(
            httpClient: $pluginClient,
            requestFactory: $this->requestFactory,
            streamFactory: $this->streamFactory,
        );
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
     * @throws Throwable
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

        try {
            $response = $this->getClient()->sendRequest(
                request: $request,
            );
        } catch (Throwable $exception) {
            throw $exception;
        }

        return $response;
    }

    /**
     * Send a POST request.
     *
     * @param string $uri
     * @param array $body
     * @param array $headers
     *
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws Throwable
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

        try {
            $response = $this->getClient()->sendRequest(
                request: $request,
            );
        } catch (Throwable $exception) {
            throw $exception;
        }

        return $response;
    }

    /**
     * Send a PUT request.
     * @param string $uri
     * @param array $body
     * @param array $headers
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws Throwable
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

        try {
            $response = $this->getClient()->sendRequest(
                request: $request,
            );
        } catch (Throwable $exception) {
            throw $exception;
        }

        return $response;
    }

    /**
     * Send a PATCH request.
     * @param string $uri
     * @param array $body
     * @param array $headers
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws Throwable
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

        try {
            $response = $this->getClient()->sendRequest(
                request: $request,
            );
        } catch (Throwable $exception) {
            throw $exception;
        }

        return $response;
    }

    /**
     * Send a DELETE request.
     * @param string $uri
     * @param array $headers
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws Throwable
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

        try {
            $response = $this->getClient()->sendRequest(
                request: $request,
            );
        } catch (Throwable $exception) {
            throw $exception;
        }

        return $response;
    }

    /**
     * Send an OPTIONS request.
     * @param string $uri
     * @param array $headers
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws Throwable
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

        try {
            $response = $this->getClient()->sendRequest(
                request: $request,
            );
        } catch (Throwable $exception) {
            throw $exception;
        }

        return $response;
    }

    public function addPlugin(Plugin $plugin): void
    {
        $this->plugins[] = $plugin;
    }
}
