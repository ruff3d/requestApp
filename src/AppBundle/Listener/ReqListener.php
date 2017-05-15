<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 15.05.17
 * Time: 13:20
 */

namespace AppBundle\Listener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
//use Symfony\Component\HttpFoundation\Response;

class ReqListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if ($event->getException() instanceof NotFoundHttpException) {
            $response = new RedirectResponse('storeRequest/first', 301);
            $event->setResponse($response);
        }
    }


}