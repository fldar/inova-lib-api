<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use App\EventListener\Resolve\{
    DomainException as HandleDomainException,
    HandledException,
    AccessDeniedException as HandleAccessDeniedException,
    RoutingException
};

class ExceptionListener
{
    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $previous = $exception->getPrevious() ?? $exception;

        switch ($previous) {
            case $previous instanceof ResourceNotFoundException:
                $json = (new RoutingException())->getFinalError($exception);
                break;
            case $previous instanceof AccessDeniedException:
                $json = (new HandleAccessDeniedException())->getFinalError($exception);
                break;
            case $previous instanceof \DomainException:
                $json = (new HandleDomainException())->getFinalError($exception);
                break;
            case $previous instanceof \Throwable:
                $json = (new HandledException())->getFinalError($exception);
                break;
            default:
                $json = new JsonResponse();
                break;
        }

        $event->setResponse($json);
    }
}
