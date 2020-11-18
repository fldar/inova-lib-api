<?php

namespace App\EventListener;

use App\EventListener\Resolve\HandledException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        switch ($exception) {
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
