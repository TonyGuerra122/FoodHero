<?php

namespace App\Exceptions\Http;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class InternalServerErrorException
 *
 * Represents an HTTP 500 Internal Server Error exception.
 */
final class InternalServerErrorException extends HttpException
{
    public function __construct(string $message = 'Internal Server Error')
    {
        parent::__construct(500, $message);
    }
}
