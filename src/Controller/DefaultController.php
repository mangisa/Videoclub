<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'my_name' => $this->getParameter('app.admin_name'),
            'my_mail' => $this->getParameter('app.admin_email'),
        ]);
    }

    /**
     * @Route("/home", name="home")
     */
    public function home(): Response
    {
        return $this->render('default/home.html.twig', [
            'my_name' => $this->getParameter('app.admin_name'),
            'my_mail' => $this->getParameter('app.admin_email'),
        ]);
    }
}
