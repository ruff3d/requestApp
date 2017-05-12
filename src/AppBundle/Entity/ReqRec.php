<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 5/6/17
 * Time: 15:00
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="req_rec")
 */
class ReqRec
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @ORM\Column(type="json_array")
     */
    private $headers; // (Request headers);

    /**
     * @ORM\Column(type="string")
     */
    private $body; //(Request body);

    /**
     * @ORM\Column(type="string")
     */
    private $route; //(Route of request URI);

    /**
     * @ORM\Column(type="string")
     */
    private $method; //(HTTP method of request);

    /**
     * @ORM\Column(type="string")
     */
    private $IP; //(IP of client);

    /**
     * @ORM\Column(type="datetime")
     */
    private $created; //(date and time of request);

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param string $route
     * @return $this
     */
    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return $this
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getIP()
    {
        return $this->IP;
    }

    /**
     * @param string $IP
     * @return $this
     */
    public function setIP($IP)
    {
        $this->IP = $IP;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param DateTime $created
     * @return $this
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     * @return $this
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    }
}
