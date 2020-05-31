<?php

declare(strict_types=1);

namespace JustSteveKing\HttpSlim;

use Psr\Http\Message\ResponseInterface;

interface HttpClientInterface
{
    /**
     * @param string $uri
     * @param array  $headers
     * @return ResponseInterface
     */
    public function get(string $uri, array $headers = []): ResponseInterface;

    /**
     * @param string $uri
     * @param array $body
     * @param array $headers
     * @return ResponseInterface
     */
    public function post(string $uri, array $body, array $headers = []): ResponseInterface;

    /**
     * @param string $uri
     * @param array $body
     * @param array $headers
     * @return ResponseInterface
     */
    public function put(string $uri, array $body, array $headers = []): ResponseInterface;

    /**
     * @param string $uri
     * @param array $body
     * @param array $headers
     * @return ResponseInterface
     */
    public function patch(string $uri, array $body, array $headers = []): ResponseInterface;

    /**
     * @param string $uri
     * @param array $headers
     * @return ResponseInterface
     */
    public function delete(string $uri, array $headers = []): ResponseInterface;
}
