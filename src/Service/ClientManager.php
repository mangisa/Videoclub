<?php

namespace App\Service;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;

class ClientManager
{
    private $entityManager;
    private $clientRepository;

    public function __construct(EntityManagerInterface $entityManager, ClientRepository $clientRepository)
    {
        $this->entityManager = $entityManager;
        $this->clientRepository = $clientRepository;
    }

    public function find(int $id): ?Client
    {
        if (!$id) return null;
        
        return $this->clientRepository->find($id);
    }

    public function findAll(): array
    {
        return $this->clientRepository->findAll();
    }

    public function persist(Client $client): Client
    {
        $this->entityManager->persist($client);
        return $client;
    }

    public function create(): Client
    {
        $client = new Client();
        return $client;
    }

    public function save(Client $client): Client
    {
        $this->entityManager->persist($client); 
        $this->entityManager->flush();
        return $client;
    }

    public function reload(Client $client): Client
    {
        $this->entityManager->refresh($client);
        return $client;
    }

    public function remove(Client $client): void
    {
        $this->entityManager->remove($client);
        $this->entityManager->flush();
    }

}