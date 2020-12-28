<?php

namespace App\EventListener\Resolve;

use Throwable;
use Symfony\Component\HttpFoundation\JsonResponse;

class AccessDeniedException extends AbstractHandledException
{
    /** @var string  */
    protected const MESSAGE = 'Access Denied!';

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
