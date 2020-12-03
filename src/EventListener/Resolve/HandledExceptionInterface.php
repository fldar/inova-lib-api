<?php

namespace App\EventListener\Resolve;

use Symfony\Component\HttpFoundation\JsonResponse;

interface HandledExceptionInterface
{
    /**
     * @param \Throwable $throwable
     * @param string|null $message
     * @return JsonResponse
     */
    public function getFinalError(\Throwable $throwable, ?string $message = null): JsonResponse;
}