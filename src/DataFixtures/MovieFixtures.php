<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    public function getOrder(): int
	{
        return 2;
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->arrayDataMovies() as $dataMovie) {
            $movie = new Movie();
            $movie->setTitle($dataMovie['title']);
            $movie->setPrice($dataMovie['price']);
            $movie->setDuration($dataMovie['duration']);
            $movie->setDirector($dataMovie['director']);
            $movie->setReleaseDate(new \DateTime($dataMovie['release_date']));
            $manager->persist($movie);
        }
        
        $manager->flush();
    }

    private function arrayDataMovies(): array
    {
        $data = array(
            array(
                'title' => 'Jurassick Park',
                'price' => 1.95,
                'duration' => 127,
                'director' => 'Steven Spielberg',
                'release_date' => '2004/04/06'
            ),
            array(
                'title' => 'The Lost World',
                'price' => 1.95,
                'duration' => 129,
                'director' => 'Steven Spielberg',
                'release_date' => '1997/05/18'
            ),
            array(
                'title' => 'Jurassic Park III',
                'price' => 1.95,
                'duration' => 92,
                'director' => 'Joe Johnston',
                'release_date' => '2001/07/18'
            ), 
        );

        return $data;
    }
}