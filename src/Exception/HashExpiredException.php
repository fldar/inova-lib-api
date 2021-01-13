<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class HashExpiredException extends \DomainException
{
    /** @var string  */
    public const MESSAGE = 'Invalid or expired token, request a new one.';

    public function __construct()
    {
        parent::__construct(self::MESSAGE, Response::HTTP_BAD_REQUEST);
    }
}
