<?php

namespace App\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClientControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', 'client/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testShow()
    {
        $client = static::createClient();

        $client->request('GET', 'client/show');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function newTest()
    {
        $client = static::createClient();

        $client->request('GET, POST', 'client/new');

        $this->assertEquals(405, $client->getResponse()->getStatusCode());
    }

    public function testEdit()
    {
        $client = static::createClient();

        $client->request('GET, POST', 'client/edit');

        $this->assertEquals(405, $client->getResponse()->getStatusCode());
    }
    

}