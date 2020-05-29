<?php

declare(strict_types=1);

namespace JustSteveKing\HttpSlim;

use Psr\Http\Message\ResponseInterface;

interface HttpClientInterface
{
    /**
     * @param string $uri
     * @return ResponseInterface
     */
    public function get(string $uri): ResponseInterface;

    /**
     * @param string $uri
     * @param array $body
     * @return ResponseInterface
     */
    public function post(string $uri, array $body): ResponseInterface;

    /**
     * @param string $uri
     * @param array $body
     * @return ResponseInterface
     */
    public function put(string $uri, array $body): ResponseInterface;

    /**
     * @param string $uri
     * @param array $body
     * @return ResponseInterface
     */
    public function patch(string $uri, array $body): ResponseInterface;

    /**
     * @param string $uri
     * @return ResponseInterface
     */
    public function delete(string $uri): ResponseInterface;
}
