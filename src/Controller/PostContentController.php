<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Routing\Annotation\Route;

class PostContentController
{
    /**
     * @Route("/contents", name="post_content", methods="POST")
     */
    public function __invoke(NotifierInterface $notifier, Request $request)
    {
        if(null !== $message = (\json_decode($request->getContent(), true)['message'] ?? null)) {
            $notifier->send(new Notification($message, ['chat/linkedin']));
            return new JsonResponse('message posted with success', 201);
        }

        throw new BadRequestException('Missing "message" in body');
    }
}
