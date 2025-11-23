<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: '`Group`')]
#[Vich\Uploadable]
class Group
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::GUID)]
    private ?string $token = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[Vich\UploadableField(mapping: 'group_images', fileNameProperty: 'image1Name')]
    private ?File $image1File = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $image1Name = null;

    #[Vich\UploadableField(mapping: 'group_images', fileNameProperty: 'image2Name')]
    private ?File $image2File = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $image2Name = null;

    /**
     * @var Collection<int, UserGroup>
     */
    #[ORM\OneToMany(targetEntity: UserGroup::class, mappedBy: 'group')]
    private Collection $userGroups;

    /**
     * @var Collection<int, Photo>
     */
    #[ORM\OneToMany(targetEntity: Photo::class, mappedBy: 'group')]
    private Collection $photos;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isExplicit = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isModerated = null;

    public function __construct()
    {
        $this->userGroups = new ArrayCollection();
        $this->photos = new ArrayCollection();

        // Génération automatique du token (UUID v4)
        $this->token = Uuid::v6()->toRfc4122();

        // Génération automatique de la date de création
        $this->created_at = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getImage1Name(): ?string
    {
        return $this->image1Name;
    }

    public function setImage1Name(string $imageName): static
    {
        $this->image1Name = $imageName;

        return $this;
    }

    public function getImage1File(): ?File
    {
        return $this->image1File;
    }

    public function setImage1File(?File $image1File = null): void
    {
        $this->image1File = $image1File;
    }

    public function getImage2File(): ?File
    {
        return $this->image2File;
    }

    public function setImage2File(?File $image2File = null): void
    {
        $this->image2File = $image2File;
    }

    public function getImage2Name(): ?string
    {
        return $this->image2Name;
    }

    public function setImage2Name(string $imageName): static
    {
        $this->image2Name = $imageName;
        return $this;
    }

    /**
     * @return Collection<int, UserGroup>
     */
    public function getUserGroups(): Collection
    {
        return $this->userGroups;
    }

    public function addUserGroup(UserGroup $userGroup): static
    {
        if (!$this->userGroups->contains($userGroup)) {
            $this->userGroups->add($userGroup);
            $userGroup->setGroupId($this);
        }

        return $this;
    }

    public function removeUserGroup(UserGroup $userGroup): static
    {
        if ($this->userGroups->removeElement($userGroup)) {
            // set the owning side to null (unless already changed)
            if ($userGroup->getGroup() === $this) {
                $userGroup->setGroup(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): static
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setGroup($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): static
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getGroup() === $this) {
                $photo->setGroup(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isExplicit(): ?bool
    {
        return $this->isExplicit;
    }

    public function setIsExplicit(?bool $isExplicit): static
    {
        $this->isExplicit = $isExplicit;

        return $this;
    }

    public function isModerated(): ?bool
    {
        return $this->isModerated;
    }

    public function setIsModerated(?bool $isModerated): static
    {
        $this->isModerated = $isModerated;

        return $this;
    }
}
