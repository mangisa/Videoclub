<?php

namespace App\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClientControllerTest extends WebTestCase
{
    public function testNew()
    {
        $client = static::createClient();

        $client->request('GET', 'client/new/');

        $this->assertEquals(301, $client->getResponse()->getStatusCode());
    }

    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', 'client/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testShow()
    {
        $client = static::createClient();

        $client->request('GET', 'client/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testEdit()
    {
        $client = static::createClient();

        $client->request('GET, POST', 'client/edit');

        $this->assertEquals(405, $client->getResponse()->getStatusCode());
    }
    

}