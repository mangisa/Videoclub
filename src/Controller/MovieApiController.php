<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index(): Response
    {
        $movies = $this->getDoctrine()->getRepository(Movie::class)->findAll();

        return $this->json($movies);
    }


    /**
     * @Route("/by_get/{id}", name="movies_api_show_get", methods={"GET"})
     */
    public function showByGet($id): Response
    {
        $movie = $this->getDoctrine()->getRepository(Movie::class)->findOneBy(['id' => $id], ['id' => 'ASC']);

        return $this->respond($movie);
    }

    /**
     * @Route("/by_post/{id}", name="movies_api_show_post", methods={"POST"})
     */
    public function showByPost(Request $request): Response
    {
        $movieId = $request->get('id');

        $movie = $this->getDoctrine()->getRepository(Movie::class)->findOneBy(['id' => $movieId], ['id' => 'ASC']);

        if (!$movie) {
            throw new NotFoundHttpException('Movie not exist in ddbb');
        }

        return $this->respond($movie);
    }

    /**
     * @Route("/create", name="movies_api_create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $form = $this->buidForm(MovieType::class);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        /** @var Movie $movie */
        $movie = $form->getData();

        $this->getDoctrine()->getManager()->persist($movie);
        $this->getDoctrine()->getManager()->flush();

        //return $this->json($movie);
        return $this->respond($movie);
    }

    /**
     * @Route("/update/{id}", name="movies_api_update", methods={"PATCH"})
     */
    public function update(Request $request): Response
    {
        $movieId = $request->get('id');

        $movie = $this->getDoctrine()->getRepository(Movie::class)->findOneBy(['id' => $movieId], ['id' => 'ASC']);

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

        $this->getDoctrine()->getManager()->persist($movie);
        $this->getDoctrine()->getManager()->flush();

        //return $this->json($movie);
        return $this->respond($movie);
    }

    /**
     * @Route("/delete_by_post/{id}", name="movies_api_delete_post", methods={"DELETE"})
     */
    public function delete(Request $request): Response
    {
        $movieId = $request->get('id');

        $movie = $this->getDoctrine()->getRepository(Movie::class)->findOneBy(['id' => $movieId], ['id' => 'ASC']);

        if (!$movie) {
            throw new NotFoundHttpException('Movie not found');
        }

        $this->getDoctrine()->getManager()->remove($movie);
        $this->getDoctrine()->getManager()->flush();

        return $this->respond(null);
    }

}
