<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use App\Service\MovieManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/movies")
 */
class MovieApiController extends AbstractApiController
{
    /**
     * @Route("/", name="movies_api", methods={"GET"})
     */
    public function index(MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findAll();

        return $this->json($movies);
    }

    /**
     * @Route("/by_get/{id}", name="movies_api_show_get", methods={"GET"})
     */
    public function showByGet($id, MovieManager $movieManager): Response
    {
        $movie = $movieManager->find($id);

        if (!$movie) {
            throw new NotFoundHttpException('Movie not exist in ddbb');
        }

        return $this->respond($movie);
    }

    /**
     * @Route("/by_post/{id}", name="movies_api_show_post", methods={"POST"})
     */
    public function showByPost(Request $request, MovieManager $movieManager): Response
    {
        $movieId = $request->get('id');

        $movie = $movieManager->find($movieId);

        if (!$movie) {
            throw new NotFoundHttpException('Movie not exist in ddbb');
        }

        return $this->respond($movie);
    }

    /**
     * @Route("/create", name="movies_api_create", methods={"POST"})
     */
    public function create(Request $request, MovieManager $movieManager): Response
    {
        $form = $this->buidForm(MovieType::class);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        /** @var Movie $movie */
        $movie = $form->getData();
        $movie = $movieManager->save($movie);

        return $this->respond($movie);
    }

    /**
     * @Route("/update/{id}", name="movies_api_update", methods={"PATCH"})
     */
    public function update(Request $request, MovieManager $movieManager): Response
    {
        $movieId = $request->get('id');

        $movie = $movieManager->find($movieId);

        if (!$movie) {
            throw new NotFoundHttpException('Movie not exist in ddbb');
        }

        $form = $this->buidForm(MovieType::class, $movie, [
            'method' => $request->getMethod(),
        ]);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        /** @var Movie $movie */
        $movie = $form->getData();
        $movie = $movieManager->save($movie);

        return $this->respond($movie);
    }

    /**
     * @Route("/delete_by_post/{id}", name="movies_api_delete_post", methods={"DELETE"})
     */
    public function delete(Request $request, MovieManager $movieManager): Response
    {
        $movieId = $request->get('id');

        $movie = $movieManager->find($movieId);

        if (!$movie) {
            throw new NotFoundHttpException('Movie not found');
        }

        $movieManager->remove($movie);

        return $this->respond(null);
    }

}
