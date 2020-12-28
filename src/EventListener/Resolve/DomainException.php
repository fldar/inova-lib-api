<?php

namespace App\EventListener\Resolve;

use Throwable;
use Symfony\Component\HttpFoundation\JsonResponse;

class DomainException extends AbstractHandledException
{
    /**
     * @param Throwable $throwable
     * @param string|null $message
     * @return JsonResponse
     */
    public function getFinalError(Throwable $throwable, string $message = null): JsonResponse
    {
        return parent::getFinalError($throwable, $throwable->getMessage());
    }
}
