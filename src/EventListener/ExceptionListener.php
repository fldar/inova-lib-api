<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use App\EventListener\Resolve\{HandledException, HandleAccessDeniedException};
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExceptionListener
{
    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        switch ($exception) {
            case $exception instanceof HttpException:
                $json = (new HandleAccessDeniedException())->getFinalError($exception);
                break;
            case $exception instanceof \Throwable:
                $json = (new HandledException())->getFinalError($exception);
                break;
            default:
                $json = new JsonResponse();
                break;
        }

        $event->setResponse($json);
    }
}
