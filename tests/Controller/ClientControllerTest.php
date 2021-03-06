<?php

namespace App\Test\Controller;

use App\Entity\Client;
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

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function testNew()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $client->request('GET', 'client/new');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
   
    public function testCreateCorrectFormFields()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $crawler = $client->request('GET', 'client/new');

        $buttonCrawlerNode = $crawler->selectButton('submit');

        $form = $buttonCrawlerNode->form();

        $form['client[name]'] = 'name';
        $form['client[surname]'] = 'surname';
        $form['client[birthdate]'] = '2000-12-31';

        $client->submit($form);
        
        $this->assertTrue($client->getResponse()->isRedirect('/client/'));
    }

    /**
     * @dataProvider clientsData
     */
    public function testCreateIncorrectFormFields($name, $surname, $birthdate)
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $crawler = $client->request('GET', 'client/new');

        $buttonCrawlerNode = $crawler->selectButton('submit');

        $form = $buttonCrawlerNode->form();

        $form['client[name]'] = $name;
        $form['client[surname]'] = $surname;
        $form['client[birthdate]'] = $birthdate;

        $client->submit($form);  

        $this->assertEquals(422, $client->getResponse()->getStatusCode());
    }

    public function testShowCorrectIdParameter()
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

    public function testShowIncorrectIdParameter()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $client->request('GET', 'client/0');

        $this->assertTrue($client->getResponse()->isRedirect('/client/'));
    }

    public function testEditCorrectIdParameter()
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

    public function testEditIncorrectIdParameter()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $client->request('GET', 'client/0/edit');

        $this->assertTrue($client->getResponse()->isRedirect('/client/'));
    }

    public function testUpdateCorrectFormFields()
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
        $form['client[birthdate]'] = '1990-07-25';

        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect('/client/'));
    }

    /**
     * @dataProvider clientsData
     */
    public function testUpdateIncorrectFormFields($name, $surname, $birthdate)
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
        $form['client[birthdate]'] = $birthdate;

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

    public function clientsData(): array
    {
        return [
            ['', 'surname', '1999-11-25'], // Null mame
            ['name', '', '1999-11-25'], // Null surname
            ['name', 'surname', ''], // Null birdthDate
        ];
    }
}