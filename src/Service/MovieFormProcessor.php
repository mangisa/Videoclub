<?php

namespace App\Service;

use App\Entity\Movie;
use App\Form\MovieType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class MovieFormProcessor
{
    private $movieManager;
    private $formFactoryInterface;
    
    public function __construct(
        MovieManager $movieManager,
        FormFactoryInterface $formFactoryInterface
    ) {
        $this->movieManager = $movieManager;
        $this->formFactoryInterface = $formFactoryInterface;
    }

    public function __invoke(Movie $movie, Request $request): array
    {
        $form = $this->formFactoryInterface->create(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $movie = $this->movieManager->save($movie); 
            $movie = $this->movieManager->reload($movie);

            return [$movie, null];
        } 

        return [null, $form];
    }
}