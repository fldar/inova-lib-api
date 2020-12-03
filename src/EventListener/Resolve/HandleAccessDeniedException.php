<?php

namespace App\EventListener\Resolve;

use Symfony\Component\HttpFoundation\JsonResponse;

class HandleAccessDeniedException extends AbstractHandledException
{
    /** @var string  */
    protected const MENSAGEM = 'Access Denied!';

    /**
     * @param \Throwable $throwable
     * @param string|null $message
     * @return JsonResponse
     */
    public function getFinalError(\Throwable $throwable, string $message = null): JsonResponse
    {
        return parent::getFinalError($throwable, self::MENSAGEM);
    }
}
