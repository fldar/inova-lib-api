<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class AuthenticationRequiredException extends \DomainException
{
    /** @var string  */
    public const MESSAGE = 'You need to authenticate first';

    public function __construct()
    {
        parent::__construct(self::MESSAGE, Response::HTTP_UNAUTHORIZED);
    }
}
