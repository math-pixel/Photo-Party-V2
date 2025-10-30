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
    #[Route('/api/photos', name: 'api_photo_upload', methods: ['POST'])]
    public function uploadPhoto(
        Request $request,
        EntityManagerInterface $em,
        PhotoPublisher $publisher
    ): Response {
        $base64 = $request->get('image'); // La clef de l'image envoyée
        if (!$base64) {
            return new JsonResponse(['error' => 'No image provided'], 400);
        }

        // Extraire le content type
        if (preg_match('/^data:image\/(\w+);base64,/', $base64, $matches)) {
            $imageType = $matches[1]; // jpg, png…
            $base64 = substr($base64, strpos($base64, ',') + 1);
            $binary = base64_decode($base64);

            if ($binary === false) {
                return new JsonResponse(['error' => 'Invalid base64 data'], 400);
            }

            $filename = uniqid('photo_') . '.' . $imageType;
            $targetPath = $this->getParameter('upload_directory') . '/' . $filename;
            file_put_contents($targetPath, $binary);

            // Enregistrement en DB
            $photo = new Photo();
            $photo->setFilename($filename);
            $photo->setIsNsfw(false); // Temporaire – IA viendra mettre à jour
            $photo->setUploadedAt(new \DateTimeImmutable());

            $em->persist($photo);
            $em->flush();

            // Construire l'URL publique
            $photoUrl = $request->getSchemeAndHttpHost() . '/uploads/photos/' . $filename;

            // Publie l'événement Mercure
            $publisher->publish($photoUrl, $photo->getId());

            // Retourne l'URL de l’image
            return new JsonResponse([
                'success' => true,
                'id' => $photo->getId(),
                'url' => $photoUrl
            ]);
        }

        return new JsonResponse(['error' => 'Invalid image format'], 400);
    }
}
