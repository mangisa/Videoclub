<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractApiController extends AbstractFOSRestController
{
    protected function buidForm(string $type, $data = null, array $options = []): FormInterface
    {
        $options = array_merge($options, array(
            'csrf_protection' => false,
        ));

        return $this->container->get('form.factory')->createNamed('', $type, $data, $options);
    }

    protected function respond($data, $statusCode = Response::HTTP_OK): Response
    {
        return $this->handleView($this->view($data, $statusCode));
    }
}
