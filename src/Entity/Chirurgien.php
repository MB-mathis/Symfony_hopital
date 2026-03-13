<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ChirurgienRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChirurgienRepository::class)]
#[ApiResource]
class Chirurgien {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Greffe>
     */
    #[ORM\OneToMany(targetEntity: Greffe::class, mappedBy: 'chirurgien')]
    private Collection $greffes;

    public function __construct()
    {
        $this->greffes = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getNom(): ?string {
        return $this->nom;
    }

    public function setNom(string $nom): static {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static {
        $this->prenom = $prenom;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Greffe>
     */
    public function getGreffes(): Collection
    {
        return $this->greffes;
    }

    public function addGreffe(Greffe $greffe): static
    {
        if (!$this->greffes->contains($greffe)) {
            $this->greffes->add($greffe);
            $greffe->setChirurgien($this);
        }

        return $this;
    }

    public function removeGreffe(Greffe $greffe): static
    {
        if ($this->greffes->removeElement($greffe)) {
            // set the owning side to null (unless already changed)
            if ($greffe->getChirurgien() === $this) {
                $greffe->setChirurgien(null);
            }
        }

        return $this;
    }
}
