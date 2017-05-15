<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    private $client;
    public function __construct()
    {
//        parent::__construct();
        $this->client = static::createClient();
    }

    public function testIndex()
    {

        $crawler = $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
    }

    public function testFirst(){
        $this->client->request('GET', '/storeRequest/first');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains('true', $this->client->getResponse()->getContent());
    }

    public function testAnother(){
        $this->client->request('GET', '/storeRequest/second');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains('true', $this->client->getResponse()->getContent());
    }
}
