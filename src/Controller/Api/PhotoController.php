<?php
// src/Controller/Api/PhotoController.php

namespace App\Controller\Api;

use App\Entity\Photo;
use App\Service\PhotoPublisher;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PhotoController extends AbstractController
{
    #[Route('/api/update/photo', name: 'api_photo_upload', methods: ['POST'])]
    public function uploadPhoto(
        Request $request,
        EntityManagerInterface $em,
        PhotoPublisher $publisher
    ): Response {
        $photoId = $request->get('photoID');
        $isAllowed = $request->get('isAllowed');

        if (!$photoId || !$isAllowed) {
            return new JsonResponse(['error' => 'missing provided'], 400);
        }

        $photo = $em->getRepository(Photo::class)->find($photoId);
        $photo->setIsAllowed($isAllowed);
        $em->persist($photo);
        $em->flush();

        try {
            $publisher->publishUpdatePhotoAllowed($photoId, $isAllowed);
        }catch (\Exception $exception){
            return new JsonResponse(['error' => $exception->getMessage()], 400);
        }

        return new JsonResponse([
                'success' => true,
                'id' => $photoId,
                'isAllowed' => $isAllowed
            ]);
    }
}
