<?php

namespace App\Controller;

use App\Service\GroupService;
use App\Entity\Group;
use App\Entity\UserGroup;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{

    public function __construct(
        private GroupService $groupService
    ) {}

    #[Route('/', name: 'app_main')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $groups = $this->groupService->getGroupsOfUser($user);

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'groups' => $groups
        ]);
    }
}
