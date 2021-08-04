<?php

namespace App\Test\Controller;

use App\Entity\Client;
use PHPUnit\Framework\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClientControllerTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testNew()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $client->request('GET', 'client/new');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function datosCliente(): array
    {
        return [
            ['', 'surname'],
            ['name', '']
        ];
    }

    public function testCreateOK()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $crawler = $client->request('GET', 'client/new');

        $buttonCrawlerNode = $crawler->selectButton('submit');

        $form = $buttonCrawlerNode->form();

        $form['client[name]'] = 'name';
        $form['client[surname]'] = 'surname';

        $client->submit($form);
        
        $this->assertTrue($client->getResponse()->isRedirect('/client/'));
    }

    /**
     * @dataProvider datosCliente
     * @group failing
     */
    public function testCreateKO($name, $surname)
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $crawler = $client->request('GET', 'client/new');

        $buttonCrawlerNode = $crawler->selectButton('submit');

        $form = $buttonCrawlerNode->form();

        $form['client[name]'] = $name;
        $form['client[surname]'] = $surname;

        $client->submit($form);  

        $this->assertEquals(422, $client->getResponse()->getStatusCode());
    }

    public function testShow()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $entity = $this->entityManager
            ->getRepository(Client::class)
            ->findOneBy([], ['id' => 'DESC'])
        ;

        $client->request('GET', 'client/' . $entity->getId());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testShowIncorrectId()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $client->request('GET', 'client/0');

        $this->assertTrue($client->getResponse()->isRedirect('/client/'));
    }

    public function testEdit()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $entity = $this->entityManager
            ->getRepository(Client::class)
            ->findOneBy([], ['id' => 'DESC'])
        ;

        $client->request('GET', 'client/' . $entity->getId() . '/edit');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testEditIncorrectId()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $client->request('GET', 'client/0/edit');

        $this->assertTrue($client->getResponse()->isRedirect('/client/'));
    }

    public function testUpdateOK()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $entity = $this->entityManager
            ->getRepository(Client::class)
            ->findOneBy([], ['id' => 'DESC'])
        ;

        $crawler = $client->request('GET', 'client/' . $entity->getId() . '/edit');    

        $buttonCrawlerNode = $crawler->selectButton('submit');

        $form = $buttonCrawlerNode->form();

        $form['client[name]'] = 'Edit';
        $form['client[surname]'] = 'Update by Test';

        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect('/client/'));
    }

    /**
     * @dataProvider datosCliente
     */
    public function testUpdateKO($name, $surname)
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $entity = $this->entityManager
            ->getRepository(Client::class)
            ->findOneBy([], ['id' => 'DESC'])
        ;

        $crawler = $client->request('GET', 'client/' . $entity->getId() . '/edit');

        $buttonCrawlerNode = $crawler->selectButton('submit');

        $form = $buttonCrawlerNode->form();

        $form['client[name]'] = $name;
        $form['client[surname]'] = $surname;

        $client->submit($form);  

        $this->assertEquals(422, $client->getResponse()->getStatusCode());
    }

    public function testIndex()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $client->request('GET', 'client/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @group failing
     */
    public function testDelete()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $entity = $this->entityManager
            ->getRepository(Client::class)
            ->findOneBy([], ['id' => 'DESC'])
        ;

        $crawler = $client->request('GET', 'client/' . $entity->getId());

        $buttonCrawlerNode = $crawler->selectButton('delete');

        $form = $buttonCrawlerNode->form();

        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect('/client/'));
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}