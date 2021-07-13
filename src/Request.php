<?php

declare(strict_types=1);

namespace JustSteveKing\HttpSlim;

class Request
{
    /**
     * @var string
     */
    public const GET = 'GET';

    /**
     * @var string
     */
    public const POST = 'POST';

    /**
     * @var string
     */
    public const PUT = 'PUT';

    /**
     * @var string
     */
    public const PATCH = 'PATCH';

    /**
     * @var string
     */
    public const DELETE = 'DELETE';

    /**
     * @var string
     */
    public const OPTIONS = 'OPTIONS';
}
