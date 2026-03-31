<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use TypeGreffe;
use App\Repository\GreffeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: GreffeRepository::class)]
#[ApiResource]
class Greffe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'greffes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Donneur $donneur = null;

    #[ORM\ManyToOne(inversedBy: 'greffes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DossierMedical $dossierMedical = null;

    #[ORM\ManyToOne(inversedBy: 'greffes')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Chirurgien $chirurgien = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateGreffe = null;

    #[ORM\Column]
    private ?int $rangGreffe = null;

    #[ORM\Column(enumType: TypeGreffe::class)]
    private ?TypeGreffe $typeGreffe = null;

    #[ORM\Column]
    private ?bool $greffonFonctionnel = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dateFinFonctionGreffon = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $causeFinFonctionGreffon = null;

    #[ORM\Column]
    private ?bool $dialyse = null;

    #[ORM\Column(nullable: true)]
    #[Gedmo\Timestampable(on: 'update')]
    private ?\DateTimeImmutable $dateDerniereDialyse = null;

    #[ORM\Column(nullable: true)]
    private ?bool $protocole = null;

    #[ORM\Column(nullable: true)]
    private ?array $data = null;

    /**
     * @var Collection<int, Document>
     */
    #[ORM\OneToMany(targetEntity: Document::class, mappedBy: 'greffe')]
    private Collection $documents;

    #[ORM\OneToOne(mappedBy: 'greffe', cascade: ['persist', 'remove'])]
    private ?GroupeHLA $groupeHLA = null;

    #[ORM\OneToOne(mappedBy: 'greffe', cascade: ['persist', 'remove'])]
    private ?Serologie $serologie = null;

    #[ORM\OneToOne(mappedBy: 'greffe', cascade: ['persist', 'remove'])]
    private ?Prelevement $prelevement = null;

    #[ORM\OneToOne(mappedBy: 'greffe', cascade: ['persist', 'remove'])]
    private ?ConditionnementImmunologique $conditionnementImmunologique = null;

    public function __construct()
    {
        $this->dateGreffe = new \DateTimeImmutable();
        $this->rangGreffe = 1;
        $this->greffonFonctionnel = true;
        $this->dialyse = false;
        $this->protocole = false;
        $this->documents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDonneur(): ?Donneur
    {
        return $this->donneur;
    }

    public function setDonneur(?Donneur $donneur): static
    {
        $this->donneur = $donneur;

        return $this;
    }

    public function getDossierMedical(): ?DossierMedical
    {
        return $this->dossierMedical;
    }

    public function setDossierMedical(?DossierMedical $dossierMedical): static
    {
        $this->dossierMedical = $dossierMedical;

        return $this;
    }

    public function getChirurgien(): ?Chirurgien
    {
        return $this->chirurgien;
    }

    public function setChirurgien(?Chirurgien $chirurgien): static
    {
        $this->chirurgien = $chirurgien;

        return $this;
    }

    public function getDateGreffe(): ?\DateTimeImmutable
    {
        return $this->dateGreffe;
    }

    public function setDateGreffe(\DateTimeImmutable $dateGreffe): static
    {
        $this->dateGreffe = $dateGreffe;

        return $this;
    }

    public function getRangGreffe(): ?int
    {
        return $this->rangGreffe;
    }

    public function setRangGreffe(int $rangGreffe): static
    {
        $this->rangGreffe = $rangGreffe;

        return $this;
    }

    public function getTypeGreffe(): ?TypeGreffe
    {
        return $this->typeGreffe;
    }

    public function setTypeGreffe(TypeGreffe $typeGreffe): static
    {
        $this->typeGreffe = $typeGreffe;

        return $this;
    }

    public function isGreffonFonctionnel(): ?bool
    {
        return $this->greffonFonctionnel;
    }

    public function setGreffonFonctionnel(bool $greffonFonctionnel): static
    {
        $this->greffonFonctionnel = $greffonFonctionnel;

        return $this;
    }

    public function getDateFinFonctionGreffon(): ?\DateTimeImmutable
    {
        return $this->dateFinFonctionGreffon;
    }

    public function setDateFinFonctionGreffon(?\DateTimeImmutable $dateFinFonctionGreffon): static
    {
        $this->dateFinFonctionGreffon = $dateFinFonctionGreffon;

        return $this;
    }

    public function getCauseFinFonctionGreffon(): ?string
    {
        return $this->causeFinFonctionGreffon;
    }

    public function setCauseFinFonctionGreffon(?string $causeFinFonctionGreffon): static
    {
        $this->causeFinFonctionGreffon = $causeFinFonctionGreffon;

        return $this;
    }

    public function isDialyse(): ?bool
    {
        return $this->dialyse;
    }

    public function setDialyse(bool $dialyse): static
    {
        $this->dialyse = $dialyse;

        return $this;
    }

    public function getDateDerniereDialyse(): ?\DateTimeImmutable
    {
        return $this->dateDerniereDialyse;
    }

    public function setDateDerniereDialyse(?\DateTimeImmutable $dateDerniereDialyse): static
    {
        $this->dateDerniereDialyse = $dateDerniereDialyse;

        return $this;
    }

    public function isProtocole(): ?bool
    {
        return $this->protocole;
    }

    public function setProtocole(?bool $protocole): static
    {
        $this->protocole = $protocole;

        return $this;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function setData(?array $data): static
    {
        $this->data = $data;

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
            $document->setGreffe($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): static
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getGreffe() === $this) {
                $document->setGreffe(null);
            }
        }

        return $this;
    }

    public function getGroupeHLA(): ?GroupeHLA
    {
        return $this->groupeHLA;
    }

    public function setGroupeHLA(?GroupeHLA $groupeHLA): static
    {
        // unset the owning side of the relation if necessary
        if ($groupeHLA === null && $this->groupeHLA !== null) {
            $this->groupeHLA->setGreffe(null);
        }

        // set the owning side of the relation if necessary
        if ($groupeHLA !== null && $groupeHLA->getGreffe() !== $this) {
            $groupeHLA->setGreffe($this);
        }

        $this->groupeHLA = $groupeHLA;

        return $this;
    }

    public function getSerologie(): ?Serologie
    {
        return $this->serologie;
    }

    public function setSerologie(?Serologie $serologie): static
    {
        // unset the owning side of the relation if necessary
        if ($serologie === null && $this->serologie !== null) {
            $this->serologie->setGreffe(null);
        }

        // set the owning side of the relation if necessary
        if ($serologie !== null && $serologie->getGreffe() !== $this) {
            $serologie->setGreffe($this);
        }

        $this->serologie = $serologie;

        return $this;
    }

    public function getPrelevement(): ?Prelevement
    {
        return $this->prelevement;
    }

    public function setPrelevement(?Prelevement $prelevement): static
    {
        // unset the owning side of the relation if necessary
        if ($prelevement === null && $this->prelevement !== null) {
            $this->prelevement->setGreffe(null);
        }

        // set the owning side of the relation if necessary
        if ($prelevement !== null && $prelevement->getGreffe() !== $this) {
            $prelevement->setGreffe($this);
        }

        $this->prelevement = $prelevement;

        return $this;
    }

    public function getConditionnementImmunologique(): ?ConditionnementImmunologique
    {
        return $this->conditionnementImmunologique;
    }

    public function setConditionnementImmunologique(ConditionnementImmunologique $conditionnementImmunologique): static
    {
        // set the owning side of the relation if necessary
        if ($conditionnementImmunologique->getGreffe() !== $this) {
            $conditionnementImmunologique->setGreffe($this);
        }

        $this->conditionnementImmunologique = $conditionnementImmunologique;

        return $this;
    }
}
