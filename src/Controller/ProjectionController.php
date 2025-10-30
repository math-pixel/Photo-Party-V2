<?php

// src/Controller/ProjectionController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectionController extends AbstractController
{
    #[Route('/projection', name: 'app_projection', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('projection/index.html.twig');
    }
}
