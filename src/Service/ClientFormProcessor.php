<?php

namespace App\Service;

use App\Entity\Client;
use App\Form\ClientType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class ClientFormProcessor
{
    private $clientManager;
    private $formFactoryInterface;
    
    public function __construct(
        ClientManager $clientManager,
        FormFactoryInterface $formFactoryInterface
    ) {
        $this->clientManager = $clientManager;
        $this->formFactoryInterface = $formFactoryInterface;
    }

    public function __invoke(Client $client, Request $request): array
    {
        $form = $this->formFactoryInterface->create(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $client = $this->clientManager->save($client); 
            $client = $this->clientManager->reload($client);

            return [$client, null];
        } 

        return [null, $form];
    }
}