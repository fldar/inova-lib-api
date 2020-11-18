<?php

namespace App\EventListener\Resolve;

use Symfony\Component\HttpFoundation\JsonResponse;

interface HandledExceptionInterface
{
    /**
     * @param \Throwable $throwable
     * @return JsonResponse
     */
    public function getFinalError(\Throwable $throwable): JsonResponse;
}