<?php

namespace App\Test\Controller;

use App\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MovieControllerTest extends WebTestCase
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

        $client->request('GET', 'movie/new');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
   
    public function testCreateCorrectFormFields()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $crawler = $client->request('GET', 'movie/new');

        $buttonCrawlerNode = $crawler->selectButton('submit_button');

        $form = $buttonCrawlerNode->form();

        $form['movie[title]'] = 'Underworld';
        $form['movie[price]'] = 1.99;

        $client->submit($form);
        
        $this->assertTrue($client->getResponse()->isRedirect('/movie/'));
    }

    /**
     * @dataProvider MoviesData
     */
    public function testCreateIncorrectFormFields($title, $price)
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $crawler = $client->request('GET', 'movie/new');

        $buttonCrawlerNode = $crawler->selectButton('submit_button');

        $form = $buttonCrawlerNode->form();

        $form['movie[title]'] = $title;
        $form['movie[price]'] = $price;

        $client->submit($form);  

        $this->assertEquals(422, $client->getResponse()->getStatusCode());
    }

    public function testShowCorrectIdParameter()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $entity = $this->entityManager
            ->getRepository(Movie::class)
            ->findOneBy([], ['id' => 'DESC'])
        ;

        $client->request('GET', 'movie/' . $entity->getId());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testShowIncorrectIdParameter()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $client->request('GET', 'movie/0');

        $this->assertTrue($client->getResponse()->isRedirect('/movie/'));
    }

    public function testEditCorrectIdParameter()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $entity = $this->entityManager
            ->getRepository(Movie::class)
            ->findOneBy([], ['id' => 'DESC'])
        ;

        $client->request('GET', 'movie/' . $entity->getId() . '/edit');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testEditIncorrectIdParameter()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $client->request('GET', 'movie/0/edit');

        $this->assertTrue($client->getResponse()->isRedirect('/movie/'));
    }

    public function testUpdateCorrectFormFields()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $entity = $this->entityManager
            ->getRepository(Movie::class)
            ->findOneBy([], ['id' => 'DESC'])
        ;

        $crawler = $client->request('GET', 'movie/' . $entity->getId() . '/edit');    

        $buttonCrawlerNode = $crawler->selectButton('submit_button');

        $form = $buttonCrawlerNode->form();

        $form['movie[title]'] = 'Pacific rim 2';
        $form['movie[price]'] = 0.95;

        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect('/movie/'));
    }

    /**
     * @dataProvider MoviesData
     */
    public function testUpdateIncorrectFormFields($title, $price)
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $entity = $this->entityManager
            ->getRepository(Movie::class)
            ->findOneBy([], ['id' => 'DESC'])
        ;

        $crawler = $client->request('GET', 'movie/' . $entity->getId() . '/edit');

        $buttonCrawlerNode = $crawler->selectButton('submit_button');

        $form = $buttonCrawlerNode->form();

        $form['movie[title]'] = $title;
        $form['movie[price]'] = $price;

        $client->submit($form);  

        $this->assertEquals(422, $client->getResponse()->getStatusCode());
    }

    public function testIndex()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $client->request('GET', 'movie/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testDelete()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $entity = $this->entityManager
            ->getRepository(Movie::class)
            ->findOneBy([], ['id' => 'DESC'])
        ;

        $crawler = $client->request('GET', 'movie/' . $entity->getId());

        $buttonCrawlerNode = $crawler->selectButton('delete_button');

        $form = $buttonCrawlerNode->form();

        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect('/movie/'));
    }

    public function MoviesData(): array
    {
        return [
            ['', 1.99], // Null title
            ['Pacific rim', ''], // Null price
        ];
    }
}