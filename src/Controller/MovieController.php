<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Service\MovieFormProcessor;
use App\Service\MovieManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/movie")
 */
class MovieController extends AbstractController
{
    /**
     * @Route("/", name="movie_index", methods={"GET","POST"})
     */
    public function index(MovieManager $movieManager): Response
    {
        return $this->render('movie/index.html.twig', [
            'movies' => $movieManager->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="movie_new", methods={"GET","POST"})
     */
    public function new(MovieManager $movieManager, MovieFormProcessor $movieFormProcessor, Request $request): Response
    {
        $movie = $movieManager->create();
        
        [$createdClient, $form] = ($movieFormProcessor)($movie, $request);

        if ($createdClient) {
            return $this->redirectToRoute('movie_index', [], Response::HTTP_CREATED);
        }

        return $this->renderForm('movie/new.html.twig', [
            'movie' => $movie,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="movie_show", methods={"GET"})
     */
    public function show(MovieManager $movieManager, int $id): Response
    {
        $movie = $movieManager->find($id);

        if (!$movie) {
            return $this->redirectToRoute('movie_index', [], Response::HTTP_FOUND);
        }

        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="movie_edit", methods={"GET","POST"})
     */
    public function edit(MovieManager $movieManager, MovieFormProcessor $movieFormProcessor, Request $request, int $id): Response
    {
        $movie = $movieManager->find($id);

        if (!$movie) {
            return $this->redirectToRoute('movie_index', [], Response::HTTP_FOUND);
        }

        [$createdClient, $form] = ($movieFormProcessor)($movie, $request);

        if ($createdClient) {
            return $this->redirectToRoute('movie_index', [], Response::HTTP_TEMPORARY_REDIRECT);
        }

        return $this->renderForm('movie/edit.html.twig', [
            'movie' => $movie,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="movie_delete", methods={"POST"})
     */
    public function delete(MovieManager $movieManager, Request $request, int $id): Response
    {
        $movie = $movieManager->find($id);

        if (!$movie) {
            return $this->redirectToRoute('client_index', [], Response::HTTP_FOUND);
        }

        if ($this->isCsrfTokenValid('delete'.$movie->getId(), $request->request->get('_token'))) {
            $movieManager->remove($movie);
        }

        return $this->redirectToRoute('movie_index', [], Response::HTTP_SEE_OTHER);
    }
}
