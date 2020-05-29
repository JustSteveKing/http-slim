<?php

declare(strict_types=1);

namespace JustSteveKing\Tests\HttpSlim\Exceptions;

use JustSteveKing\HttpSlim\Exceptions\RequestError;
use PHPUnit\Framework\TestCase;

class RequestErrorTest extends TestCase
{
    public function testErrorIsThrowWhenInvalidJsonMethodCalled()
    {
        $error = RequestError::invalidJson(new \JsonException('test'));

        $this->assertEquals(
            'Cannot encode JSON',
            $error->getMessage()
        );
    }
}
