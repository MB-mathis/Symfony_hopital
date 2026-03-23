<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DossierMedicalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: DossierMedicalRepository::class)]
#[ApiResource]
class DossierMedical {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'dossierMedical', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Patient $patient = null;

    #[ORM\ManyToOne(inversedBy: 'dossierMedicals')]
    #[ORM\JoinColumn(nullable: false)]
    #[Gedmo\Blameable(on: 'create')]
    private ?User $createdBy = null;

    #[ORM\Column]
    #[Gedmo\Timestampable(on: 'create')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Gedmo\Timestampable(on: 'update')]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Greffe>
     */
    #[ORM\OneToMany(targetEntity: Greffe::class, mappedBy: 'dossierMedical')]
    private Collection $greffes;

    #[ORM\Column(length: 255)]
    private ?string $numeroDossier = null;

    /**
     * @var Collection<int, Document>
     */
    #[ORM\OneToMany(targetEntity: Document::class, mappedBy: 'dossierMedical')]
    private Collection $documents;

    public function __construct() {
        $this->createdAt = new \DateTimeImmutable();
        $this->greffes = new ArrayCollection();
        $this->documents = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getPatient(): ?Patient {
        return $this->patient;
    }

    public function setPatient(Patient $patient): static {
        $this->patient = $patient;

        return $this;
    }

    public function getCreatedBy(): ?User {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): static {
        $this->createdBy = $createdBy;

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
            $greffe->setDossierMedical($this);
        }

        return $this;
    }

    public function removeGreffe(Greffe $greffe): static
    {
        if ($this->greffes->removeElement($greffe)) {
            // set the owning side to null (unless already changed)
            if ($greffe->getDossierMedical() === $this) {
                $greffe->setDossierMedical(null);
            }
        }

        return $this;
    }

    public function getNumeroDossier(): ?string
    {
        return $this->numeroDossier;
    }

    public function setNumeroDossier(string $numeroDossier): static
    {
        $this->numeroDossier = $numeroDossier;

        return $this;
    }

    /**
     * @return Collection<int, Document>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): static
    {
        if (!$this->documents->contains($document)) {
            $this->documents->add($document);
            $document->setDossierMedical($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): static
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getDossierMedical() === $this) {
                $document->setDossierMedical(null);
            }
        }

        return $this;
    }
}
