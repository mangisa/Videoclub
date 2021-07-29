<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClientFixtures extends Fixture
{
    public function getOrder(): int
	{
        return 1;
    }

    public function load(ObjectManager $manager): void
    {
        $client = new Client();
        $client->setName('Cliente');
        $client->setSurname('Creado con fixtures');
        $client->setNie('1345678a');
        $client->setBirthdate(new \DateTime('2004/04/23'));
        $client->setPostalcode(29500);
        $client->setAddress('C/ Donde Vive número 17');
        $client->setTown('Picasent');
        $client->setCity('Valencia');
        $client->setProvince('Comunidad Valenciana');
        $client->setCountry('España');

        $manager->persist($client);
        $manager->flush();
    }
}
