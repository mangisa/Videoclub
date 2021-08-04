<?php

namespace App\Controller;

use App\Service\ClientFormProcessor;
use App\Service\ClientManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client")
 */
class ClientController extends AbstractController
{
    /**
     * @Route("/", name="client_index", methods={"GET"})
     */
    public function index(ClientManager $clientManager): Response
    {
        return $this->render('client/index.html.twig', [
            'clients' => $clientManager->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="client_new", methods={"GET","POST"})
     */
    public function new(ClientManager $clientManager, Request $request, ClientFormProcessor $clientFormProcessor): Response
    {
        $client = $clientManager->create();

        [$createdClient , $form] = ($clientFormProcessor)($client, $request);

        if ($createdClient) {
            return $this->redirectToRoute('client_index', [], Response::HTTP_CREATED);
        }

        return $this->renderForm('client/new.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="client_show", methods={"GET"}, requirements={"id":"\d+"})
     */
    public function show(ClientManager $clientManager, int $id): Response
    {
        $client = $clientManager->find($id);

        if (!$client) {
            return $this->redirectToRoute('client_index', [], Response::HTTP_FOUND);
        }

        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="client_edit", methods={"GET","POST"}, requirements={"id":"\d+"})
     */
    public function edit(ClientManager $clientManager, Request $request, ClientFormProcessor $clientFormProcessor, int $id): Response
    { 
        $client = $clientManager->find($id);

        if (!$client) {
            return $this->redirectToRoute('client_index', [], Response::HTTP_FOUND);
        }

        [$editedClient , $form] = ($clientFormProcessor)($client, $request);

        if ($editedClient) {
            return $this->redirectToRoute('client_index', [], Response::HTTP_TEMPORARY_REDIRECT);
        }

        return $this->renderForm('client/edit.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/delete", name="client_delete", methods={"POST"})
     */
    public function delete(ClientManager $clientManager, Request $request, int $id): Response
    {
        $client = $clientManager->find($id);

        if (!$client) {
            return $this->redirectToRoute('client_index', [], Response::HTTP_FOUND);
        }

        if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
            $clientManager->remove($client);
        }

        return $this->redirectToRoute('client_index', [], Response::HTTP_SEE_OTHER);
    }
}
