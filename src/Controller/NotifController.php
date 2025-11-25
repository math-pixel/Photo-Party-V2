<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Attribute\Route;

class NotifController extends AbstractController
{
    #[Route('/notify', name: 'app_notify', methods: ['POST'])]
    public function notify(Request $request, HubInterface $hub): Response
    {
        $message = $request->request->get('message', 'Nouveau message !');

        // Publier la notification
        $update = new Update(
            topics: 'notifications',
            data: json_encode([
                'message' => $message,
                'timestamp' => time()
            ])
        );

        $hub->publish($update);

        return $this->json(['status' => 'sent']);
    }

    #[Route('/notifications', name: 'app_notifications')]
    public function index(): Response
    {
        return $this->render('notification/index.html.twig');
    }
}
