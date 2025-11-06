<?php

// src/Controller/ProjectionController.php
namespace App\Controller;

use App\Entity\Group;
use App\Entity\Photo;
use App\Entity\UserGroup;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectionController extends AbstractController
{
    #[Route('/projection/{id}', name: 'app_projection', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function index(Group $group, EntityManagerInterface $em): Response
    {

        $groupId = $group->getId();

        $photos = $em->getRepository(Photo::class)->find([
            'id' => $groupId,
        ]);

        return $this->render('projection/index.html.twig', [
            'groupParameter' => $group,
            'photos' => $photos,
        ]);
    }
}
