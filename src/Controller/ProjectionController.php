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
use Symfony\Component\Security\Http\Attribute\IsGranted;
use function Webmozart\Assert\Tests\StaticAnalysis\length;
use App\Service\GroupService;

class ProjectionController extends AbstractController
{
    public function __construct(
        private GroupService $groupService
    ) {}


    #[Route('/projection/{id}', name: 'app_projection', requirements: ['id' => '\d+'], methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(Group $group, EntityManagerInterface $em): Response
    {

        if (!$this->groupService->isUserInGroup($this->getUser(), $group)) {
            return $this->redirectToRoute('app_main');
        }

        $groupId = $group->getId();
        $photos = $em->getRepository(Photo::class)->findBy(['group' => $group]);

        $photos = array_map(function ($photo) {
            return $photo->getImageName();
        }, $photos);

//        print_r($photos);

        $encodedPhotos = json_encode($photos);

        return $this->render('projection/index.html.twig', [
            'group' => $group,
            'photos' => $encodedPhotos,
        ]);
    }
}
