<?php

namespace App\Controller;

use App\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/movies")
 */
class MovieApiController extends AbstractController
{
    /**
     * @Route("/", name="movies_api")
     */
    public function index(): Response
    {
        $movies = $this->getDoctrine()->getRepository(Movie::class)->findAll();

        return $this->json($movies);
    }


    /**
     * @Route("/{id}", name="movies_api_show", methods={"GET"})
     */
    public function show($id): Response
    {
        $movie = $this->getDoctrine()->getRepository(Movie::class)->findOneBy(['id' => $id], ['id' => 'ASC']);

        return $this->json($movie);
    }

}
