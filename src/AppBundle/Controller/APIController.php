<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use AppBundle\Entity\ReqRec;

class APIController extends FOSRestController
{

    /**
     * Available filters:
     * ● id - Id of record;
     * ● route - Route of request;
     * ● method - Request method;
     * ● ip - Client IP;
     * ● last_days - count of days. filter by period: now-last_days to now;
     * ● search - string value. return records that contains ‘search’ string in headers or body.
     *
     * @ApiDoc(
     *  description="Returns a collection of Object",
     *     parameters={
     *      {"name"="id", "dataType"="string", "required"=false,"description"="request id"},
     *      {"name"="route", "dataType"="string", "required"=false,"description"="route url"},
     *      {"name"="method", "dataType"="string", "required"=false,"description"="request method"},
     *      {"name"="ip", "dataType"="string", "required"=false,"description"="client ip"},
     *      {"name"="last_days", "dataType"="string","required"=false, "description"="period"},
     *      {"name"="search", "dataType"="string", "required"=false,"description"="find entries"}
     *  }
     * )
     *
     *
     * @Rest\Get("getRequest")
     * @param Request $r
     * @return View
     */
    public function getRequestAction(Request $r)
    {
        if ($this->checkRequest($r->query->keys())) {
            $repo = $this->getDoctrine()->getRepository('AppBundle:ReqRec');
            $res = $repo->filterRequest($r->query->all());
            return new View($res, 200);
        } else {
            return new View(['Success' => false, 'Message' => 'Wrong request parameters'], 400);
        }
    }

    /**
        Seve request
     *
     * @Rest\Route("storeRequest/first", name="first")
     * @Rest\Route("/{all}", requirements={"all"="!(api|getRequest).*"})
     * @param Request $r
     * @return View
     */
    public function firstAction(Request $r)
    {
        $em = $this->getDoctrine()->getManager();

        try {
            $reqRec = new ReqRec();
            $reqRec
                ->setBody($r->getContent())
                ->setHeaders($r->headers->all())
                ->setCreated(date_create())
                ->setIP($r->getClientIp())
                ->setRoute($r->getRequestUri())
                ->setMethod($r->getMethod());

            $em->persist($reqRec);
            $em->flush();
        } catch (Exception $exception) {
            $message = $exception->getMessage();
        }
        $success = empty($message);
        return $success ? new View(['Success' => $success, 'id' => $reqRec->getId()]) : new View(['Success' => $success, 'Message' => $message]);
    }


    private function checkRequest($keys)
    {
        $availableFilters = [
            'id',
            'route',
            'method',
            'ip',
            'last_days',
            'search'
        ];
        return empty(array_diff($keys, $availableFilters));
    }


}
