<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ConsultationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsultationRepository::class)]
#[ApiResource]
class Consultation {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'consultations')]
    private ?Patient $patient = null;

    #[ORM\Column(length: 255)]
    private ?string $motif = null;

    /**
     * @var Collection<int, Document>
     */
    #[ORM\ManyToMany(targetEntity: Document::class, inversedBy: 'consultations')]
    private Collection $documents;

    #[ORM\Column]
    private ?\DateTimeImmutable $date = null;

    #[ORM\ManyToOne(inversedBy: 'consultations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct() {
        $this->documents = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getPatient(): ?Patient {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): static {
        $this->patient = $patient;

        return $this;
    }

    public function getMotif(): ?string {
        return $this->motif;
    }

    public function setMotif(string $motif): static {
        $this->motif = $motif;

        return $this;
    }

    /**
     * @return Collection<int, Document>
     */
    public function getDocuments(): Collection {
        return $this->documents;
    }

    public function addDocument(Document $document): static {
        if (!$this->documents->contains($document)) {
            $this->documents->add($document);
        }

        return $this;
    }

    public function removeDocument(Document $document): static {
        $this->documents->removeElement($document);

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static {
        $this->date = $date;

        return $this;
    }

    public function getUser(): ?User {
        return $this->user;
    }

    public function setUser(?User $user): static {
        $this->user = $user;

        return $this;
    }
}
