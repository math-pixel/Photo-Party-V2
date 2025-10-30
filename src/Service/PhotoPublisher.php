<?php

namespace App\Service;

// src/Service/PhotoPublisher.php
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

class PhotoPublisher
{
    public function __construct(private readonly HubInterface $hub) {}

    public function publish(string $photoUrl, int $id): void
    {
        $data = [
            'id' => $id,
            'url' => $photoUrl,
        ];

        $update = new Update(
            topics: ['https://example.com/photos/new'],
            data: json_encode($data)
        );

        $this->hub->publish($update);
    }
}
