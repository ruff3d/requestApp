<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use function PHPSTORM_META\elementType;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use AppBundle\Entity\ReqRec;

class APIController extends FOSRestController
{
    /**
     * @Rest\Route("storeRequest/first")
     * @return View
     */
    public function firstAction(Request $r)
    {


        $reqRecRepo = $this->getDoctrine()->getRepository('AppBundle:ReqRec');
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
        $success = !!empty($message);
        return $success ? new View(['Success' => $success, 'id' => $reqRec->getId()]) : new View(['Success' => $success, 'Message' => $message]);//$restresult;
    }


    /**
     * Available filters:
     * ● id - Id of record;
     * ● route - Route of request;
     * ● method - Request method;
     * ● ip - Client IP;
     * ● last_days - count of days. filter by period: now-last_days to now;
     * ● search - string value. return records that contains ‘search’ string in headers or body.
     *
     * @Rest\Get("getRequest")
     * @param Request $r
     * @return View
     */
    public function getRequestAction(Request $r)
    {

        if ($this->checkRequest($r->query->keys())) {
            $qb = $this->getDoctrine()->getEntityManager()->createQueryBuilder('r');

            $qb->select('r')
                ->from('ReqRec', 'r');

            foreach ($r->query->all() as $key => $value) {
                switch ($key) {
                    case 'ip' :
                        $qb->where("r.IP = $value");
                        break;
                    case 'route' :
                        $qb->where("r.route = $value");
                        break;
                    case 'method' :
                        $qb->where("r.method = $value");
                        break;
                    case 'search' :
                        $qb->where("r.body LIKE '%{$value}%' OR  r.headers '%{$value}%'");
                        break;
                    case 'id' :
                        $qb->where("r.id' = $value ");
                        break;
                    case 'last_days' :
                        $qb->where("created >=( now() - INTERVAL {$value} DAY )"); break;
                }

                $res = $qb->getQuery()->execute();
                return new View($res, 200);

            }




            $repo = $this->getDoctrine()->getRepository('AppBundle:ReqRec');
        } else {
            return new View(['Success' => false, 'Message' => 'Wrong request parameters'],400);
        }
    }

    private function checkRequest($keys)
    {
        $availableFilters = [
            'id',
            'route',
            'method',
            'ip',
            'last_days ',
            'search'
        ];
        return empty(array_diff($keys, $availableFilters));
    }

    private function requestQuery(array $query)
    {

    }

}
