<?php

namespace App\Listener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if($exception instanceof MethodNotAllowedHttpException) {
            $response =  new JsonResponse([
                'content' => 'Method not Allowed'
            ]);
            $response->headers->replace($exception->getHeaders());
            $event->setResponse($response);
        }
    }
}
