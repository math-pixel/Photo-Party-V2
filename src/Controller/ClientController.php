<?php

namespace App\Controller;

use App\Entity\Group;
use App\Entity\Photo;
use App\Form\PhotoType;
use App\Service\PhotoPublisher;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ClientController extends AbstractController
{
    #[Route('/party/{id}', name: 'app_client', requirements: ['id' => '\d+'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(
        Group $group, Request $request, EntityManagerInterface $em,
        PhotoPublisher $photoPublisher): Response
    {

        $photo = new Photo();
        $photo->setGroup($group);

        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($photo);
            $em->flush();

            $photoPublisher->publish($group->getId(), $photo->getImageName());

            $this->addFlash('success', 'Photo ajoutée avec succès !');

            return $this->redirectToRoute('app_client', [
                'id' => $group->getId()
            ]);
        }


        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
            'form' => $form->createView(),
        ]);
    }
}
