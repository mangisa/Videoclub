<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/default", name="default")
     */
    public function index(): Response
    {
        $myMail = $this->getParameter('app.admin_email');
        
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'my_mail' => $myMail,
        ]);
    }
}
