<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
#[ApiResource]
class Document {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'documents')]
    private ?Greffe $greffe = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'documents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $uploadedBy = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $originalName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $internalName = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Consultation>
     */
    #[ORM\ManyToMany(targetEntity: Consultation::class, mappedBy: 'documents')]
    private Collection $consultations;

    public function __construct()
    {
        $this->consultations = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getGreffe(): ?Greffe {
        return $this->greffe;
    }

    public function setGreffe(?Greffe $greffe): static {
        $this->greffe = $greffe;

        return $this;
    }

    public function getType(): ?string {
        return $this->type;
    }

    public function setType(?string $type): static {
        $this->type = $type;

        return $this;
    }

    public function getUploadedBy(): ?User {
        return $this->uploadedBy;
    }

    public function setUploadedBy(?User $uploadedBy): static {
        $this->uploadedBy = $uploadedBy;

        return $this;
    }

    public function getOriginalName(): ?string {
        return $this->originalName;
    }

    public function setOriginalName(?string $originalName): static {
        $this->originalName = $originalName;

        return $this;
    }

    public function getInternalName(): ?string {
        return $this->internalName;
    }

    public function setInternalName(?string $internalName): static {
        $this->internalName = $internalName;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Consultation>
     */
    public function getConsultations(): Collection
    {
        return $this->consultations;
    }

    public function addConsultation(Consultation $consultation): static
    {
        if (!$this->consultations->contains($consultation)) {
            $this->consultations->add($consultation);
            $consultation->addDocument($this);
        }

        return $this;
    }

    public function removeConsultation(Consultation $consultation): static
    {
        if ($this->consultations->removeElement($consultation)) {
            $consultation->removeDocument($this);
        }

        return $this;
    }
}
