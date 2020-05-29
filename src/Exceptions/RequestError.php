<?php

declare(strict_types=1);

namespace JustSteveKing\HttpSlim\Exceptions;

use Error;
use JsonException;

final class RequestError extends Error
{
    /**
     * @param JsonException $error
     * @return static
     */
    public static function invalidJson(JsonException $error): self
    {
        return new static('Cannot encode JSON', 0, $error);
    }
}
