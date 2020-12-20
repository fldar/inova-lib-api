<?php

namespace App\EventListener\Resolve;

use Throwable;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\{Response, JsonResponse};

abstract class AbstractHandledException implements HandledExceptionInterface
{
    /** @var string  */
    protected const MESSAGE = 'A error has ocurred!';

    /**
     * @param Throwable $throwable
     * @param string|null $message
     * @return JsonResponse
     */
    public function getFinalError(Throwable $throwable, ?string $message = null): JsonResponse
    {
        $code = $this->getExceptionStringCode($throwable->getFile());

        return new JsonResponse([
            'erro' => $message ?? self::MESSAGE,
            'code' => $code . $throwable->getLine()
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param string $exception
     * @return string
     */
    protected function getExceptionStringCode(string $exception): string
    {
        $codeString = '';
        $className = $this->getClassName($exception);
        $chars = new ArrayCollection(str_split($className));

        $chars->map(function ($char) use (&$codeString) {
            $codeString .= ctype_upper($char) ? $char : '';
        });

        return $codeString;
    }

    /**
     * @param string $path
     * @return string
     */
    protected function getClassName(string $path): string
    {
        return (new ArrayCollection(explode('/', $path)))->last();
    }
}
