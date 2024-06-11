<?php

namespace App\Entity;

use App\Repository\ThemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThemeRepository::class)]
#[ORM\HasLifecycleCallbacks] 
class Theme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;
    
    #[ORM\Column(length: 255)]
    private string $image;
    
    #[ORM\Column(length: 255)]
    private string $icon;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $createdBy = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $updatedBy = null;
    
    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $createdAt = null;
    
    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;
    
    #[ORM\OneToMany(mappedBy: 'theme', targetEntity: Cursus::class)]
    private Collection $cursuses;

    public function __construct()
    {
        $this->cursuses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
    
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }
    /**
     * @return Collection<int, Cursus>
     */
    public function getCursuses(): Collection
    {
        return $this->cursuses;
    }
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $UpdatedAt): static
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->CreatedBy;
    }

    public function setCreatedBy(string $CreatedBy): static
    {
        $this->CreatedBy = $CreatedBy;

        return $this;
    }

    public function getUpdatedBy(): ?string
    {
        return $this->UpdateBy;
    }

    public function setUpdatedBy(string $UpdateBy): static
    {
        $this->UpdateBy = $UpdateBy;

        return $this;
    }
    public function addCursus(Cursus $cursus): static
    {
        if (!$this->cursuses->contains($cursus)) {
            $this->cursuses->add($cursus);
            $cursus->setTheme($this);
        }

        return $this;
    }

    public function removeCursus(Cursus $cursus): static
    {
        if ($this->cursuses->removeElement($cursus)) {
            // set the owning side to null (unless already changed)
            if ($cursus->getTheme() === $this) {
                $cursus->setTheme(null);
            }
        }

        return $this;
    }
    #[ORM\PrePersist]  
    public function onPrePersist(): void
    {
        $now = new \DateTime();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    #[ORM\PreUpdate]  
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTime();
    }
}