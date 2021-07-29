<?php

namespace App\Service;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;

class MovieManager
{
    private $entityManager;
    private $movieRepository;

    public function __construct(EntityManagerInterface $entityManager, MovieRepository $movieRepository)
    {
        $this->entityManager = $entityManager;
        $this->movieRepository = $movieRepository;
    }

    public function find(int $id): ?Movie
    {
        if (!$id) return null;
        
        return $this->movieRepository->find($id);
    }

    public function persist(Movie $movie): Movie
    {
        $this->entityManager->persist($movie);
        return $movie;
    }

    public function create(): Movie
    {
        $movie = new Movie();
        return $movie;
    }

    public function save(Movie $movie): Movie
    {
        $this->entityManager->persist($movie);
        $this->entityManager->flush();
        return $movie;
    }

    public function reload(Movie $movie): Movie
    {
        $this->entityManager->refresh($movie);
        return $movie;
    }

    public function remove(Movie $movie): void
    {
        $this->entityManager->remove($movie);
        $this->entityManager->flush();
    }

}