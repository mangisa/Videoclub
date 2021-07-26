<?php

namespace App\Tests\Service;

use App\Service\ClientManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ClientManagerTest extends KernelTestCase
{
    public function testSomething()
    {
        self::bootKernel();

        $container = static::getContainer();

        $clientManager = $container->get(ClientManager::class);
        $findById = $clientManager->find(false);

        $this->assertEquals(null, $findById);
    }

    public function testCorrectFindById()
    {
        self::bootKernel();

        $container = static::getContainer();

        $clientManager = $container->get(ClientManager::class);
        $findById = $clientManager->find(1);

        $this->assertEquals(1, $findById->getId());
    }
}
