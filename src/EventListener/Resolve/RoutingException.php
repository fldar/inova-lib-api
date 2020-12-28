<?php

namespace App\EventListener\Resolve;

use Throwable;
use Symfony\Component\HttpFoundation\JsonResponse;

class RoutingException extends AbstractHandledException
{
    /** @var string  */
    protected const MESSAGE = 'This page you are looking for does not exist!';

    /**
     * @param Throwable $throwable
     * @param string|null $message
     * @return JsonResponse
     */
    public function getFinalError(Throwable $throwable, string $message = null): JsonResponse
    {
        return parent::getFinalError($throwable, self::MESSAGE);
    }
}
