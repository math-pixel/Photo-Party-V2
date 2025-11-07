<?php

namespace App\Controller;

use App\Entity\Group;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ClientController extends AbstractController
{
    #[Route('/party/{id}', name: 'app_client', requirements: ['id' => '\d+'])]
    public function index(Group $group): Response
    {



        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
}
