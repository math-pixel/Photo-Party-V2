<?php

namespace App\Controller;

use App\Entity\Group;
use App\Entity\GroupRole;
use App\Entity\User;
use App\Entity\UserGroup;
use App\Form\GroupType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/group')]
class GroupController extends AbstractController
{
    #[Route('/create', name: 'app_group_create')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function create(Request $request,
                           EntityManagerInterface $em,
                           #[CurrentUser] User $user): Response
    {
        $group = new Group();
        $form = $this->createForm(GroupType::class, $group);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarder le groupe
            $em->persist($group);

            // Ajouter l'utilisateur actuel comme admin du groupe
            $userGroup = new UserGroup();
            $userGroup->setUser($user);
            $userGroup->setGroup($group);
            $userGroup->setRole(GroupRole::ADMIN->value); // L'utilisateur qui crée est admin

            $em->persist($userGroup);
            $em->flush();

            $this->addFlash('success', 'Le groupe a été créé avec succès !');

            return $this->redirectToRoute('group_show', ['id' => $group->getId()]);
        }

        return $this->render('group/create.html.twig', [
            'groupForm' => $form->createView(),
        ]);
    }


    #[Route('/{id}', name: 'group_show', requirements: ['id' => '\d+'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function show(Group $group, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        // verif si le user est dans le groupe et que il est admin
        $userGroup = $em->getRepository(UserGroup::class)->findOneBy([
            'group' => $group,
            'user' => $user,
        ]);

        if (!$userGroup) {
            $this->addFlash('error', 'Vous n\'êtes pas membre de ce groupe.');
            return $this->redirectToRoute('app_main');
        }

        return $this->render('group/show.html.twig', [
            'group' => $group,
            'userRole' => $userGroup->getRole(),
        ]);
    }

    #[Route('/join/{id}', name: 'group_join', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function join(Request $request, Group $group, EntityManagerInterface $em, #[CurrentUser] User $user): Response
    {

        // verif si le user est dans le groupe
        $userGroup = $em->getRepository(UserGroup::class)->findOneBy([
            'group' => $group,
            'user' => $user,
        ]);

        // redirect if already in group
        if ($userGroup){
            return $this->redirectToRoute('group_show', ['id' => $group->getId()]);
        }

        $form = $this->createFormBuilder()
            ->add('confirm', SubmitType::class, [
                'label' => 'Oui',
                'attr' => ['class' => 'flex-1'],
            ])
            ->add('cancel', SubmitType::class, [
                'label' => 'Non',
                'attr' => ['class' => 'flex-1'],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('confirm')->isClicked()) {

                $userGroup = new UserGroup();
                $userGroup->setUser($user);
                $userGroup->setGroup($group);
                $userGroup->setRole(GroupRole::MEMBER->value);

                $em->persist($userGroup);
                $em->flush();

                return $this->redirectToRoute('group_show', ['id' => $group->getId()]);
            }

            return $this->redirectToRoute('app_main');
        }


        return $this->render('group/join.html.twig', [
            'group' => $group,
            'confirmation_form' => $form->createView(),
        ]);
    }
}
