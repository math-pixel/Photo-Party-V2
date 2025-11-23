<?php

namespace App\Service;

// src/Service/PhotoPublisher.php
use Psr\Log\LoggerInterface;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use function Webmozart\Assert\Tests\StaticAnalysis\uuid;

class PhotoPublisher
{
    public function __construct(private readonly HubInterface $hub, private readonly LoggerInterface $logger) {}

    public function publish(string $groupId, string $photoUrl): void
    {

        $topic = "{$groupId}";

        $data = [
            'url' => $photoUrl,
        ];

        $update = new Update(
            topics: $topic,
            data: json_encode($data)
        );

        try {
            $this->hub->publish($update);
            $this->logger->info('📨 Message Mercure publié', [
                'topic' => $topic,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            $this->logger->error('❌ Erreur publication Mercure', [
                'topic' => $topic,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function publishUpdatePhotoAllowed(int $photoId, bool $isAllowed){
        $topic = "updatePhotoAllowed";

        $data = [
            'photoID' => $photoId,
            'isAllowed' => $isAllowed
        ];

        $update = new Update(
            topics: $topic,
            data: json_encode($data)
        );

        try {
            $this->hub->publish($update);
            $this->logger->info('📨 Message Mercure publié', [
                'topic' => $topic,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            $this->logger->error('❌ Erreur publication Mercure', [
                'topic' => $topic,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}
