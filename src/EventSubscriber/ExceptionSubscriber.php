<?php

/*
 * This file is part of the Reiterus package.
 *
 * (c) Pavel Vasin <reiterus@yandex.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @codeCoverageIgnore
 * Subscribe to the "kernel.exception" event
 *
 * @package App\EventSubscriber
 * @author Pavel Vasin <reiterus@yandex.ru>
 */
class ExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * Action on the "kernel.exception" event
     *
     * @param ExceptionEvent $event
     *
     * @return void
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $response = new JsonResponse();

        if ($exception instanceof HttpExceptionInterface) {
            $code = $exception->getStatusCode();
        } else {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        $response->setStatusCode($code);

        $answer = json_encode([
            'code' => $code,
            'message' => $exception->getMessage()
        ]);

        $response->setJson($answer);
        $event->setResponse($response);
    }

    /**
     * Get Subscribed Events
     *
     * @return string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.exception' => 'onKernelException',
        ];
    }
}
