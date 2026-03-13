<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\TypeGreffe;
use App\Repository\GreffeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GreffeRepository::class)]
#[ApiResource]
class Greffe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'greffes')]
    private ?Donneur $donneur = null;

    #[ORM\ManyToOne(inversedBy: 'greffes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DossierMedical $dossierMedical = null;

    #[ORM\ManyToOne(inversedBy: 'greffes')]
    #[ORM\JoinColumn(nullable: false)]
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
    private ?\DateTimeImmutable $dateDerniereDialyse = null;

    #[ORM\Column(nullable: true)]
    private ?bool $protocole = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $protocoleFichier = null;

    #[ORM\Column(nullable: true)]
    private ?array $data = null;

    public function __construct()
    {
        $this->dateGreffe = new \DateTimeImmutable();
        $this->rangGreffe = 1;
        $this->greffonFonctionnel = true;
        $this->dialyse = false;
        $this->protocole = false;
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

    public function getProtocoleFichier(): ?string
    {
        return $this->protocoleFichier;
    }

    public function setProtocoleFichier(?string $protocoleFichier): static
    {
        $this->protocoleFichier = $protocoleFichier;

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
}
