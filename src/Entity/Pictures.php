<?php

namespace App\Entity;

use App\Repository\PicturesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PicturesRepository::class)]
class Pictures
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $user_id = null;

    #[ORM\Column(length: 255)]
    private ?string $filename = null;

    #[ORM\Column]
    private ?bool $is_nsfw = null;

    #[ORM\Column]
    private ?bool $is_allowed = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): static
    {
        $this->filename = $filename;

        return $this;
    }

    public function isNsfw(): ?bool
    {
        return $this->is_nsfw;
    }

    public function setIsNsfw(bool $is_nsfw): static
    {
        $this->is_nsfw = $is_nsfw;

        return $this;
    }

    public function isAllowed(): ?bool
    {
        return $this->is_allowed;
    }

    public function setIsAllowed(bool $is_allowed): static
    {
        $this->is_allowed = $is_allowed;

        return $this;
    }
}
