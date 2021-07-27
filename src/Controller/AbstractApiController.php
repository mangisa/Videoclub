<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AbstractApiController extends AbstractController
{
    /**
     * @Route("/abstract/api", name="abstract_api")
     */
    public function index(): Response
    {
        return $this->render('abstract_api/index.html.twig', [
            'controller_name' => 'AbstractApiController',
        ]);
    }
}
