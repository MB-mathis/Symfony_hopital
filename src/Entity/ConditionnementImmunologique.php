<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\ConditionnementImmunosuppresseur;
use App\Enum\RisqueImmunologique;
use App\Repository\ConditionnementImmunologiqueRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConditionnementImmunologiqueRepository::class)]
#[ApiResource]
class ConditionnementImmunologique {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'conditionnementImmunologique', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Greffe $greffe = null;

    #[ORM\Column(nullable: true, enumType: RisqueImmunologique::class)]
    private ?RisqueImmunologique $risqueImmunologique = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaireRisqueImmunologique = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaireConditionnement = null;

    #[ORM\Column(nullable: true, enumType: ConditionnementImmunosuppresseur::class)]
    private ?ConditionnementImmunosuppresseur $conditionnementImmunosuppresseur = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getGreffe(): ?Greffe {
        return $this->greffe;
    }

    public function setGreffe(Greffe $greffe): static {
        $this->greffe = $greffe;

        return $this;
    }

    public function getRisqueImmunologique(): ?RisqueImmunologique {
        return $this->risqueImmunologique;
    }

    public function setRisqueImmunologique(?RisqueImmunologique $risqueImmunologique): static {
        $this->risqueImmunologique = $risqueImmunologique;

        return $this;
    }

    public function getCommentaireRisqueImmunologique(): ?string {
        return $this->commentaireRisqueImmunologique;
    }

    public function setCommentaireRisqueImmunologique(?string $commentaireRisqueImmunologique): static {
        $this->commentaireRisqueImmunologique = $commentaireRisqueImmunologique;

        return $this;
    }

    public function getCommentaireConditionnement(): ?string {
        return $this->commentaireConditionnement;
    }

    public function setCommentaireConditionnement(?string $commentaireConditionnement): static {
        $this->commentaireConditionnement = $commentaireConditionnement;

        return $this;
    }

    public function getConditionnementImmunosuppresseur(): ?ConditionnementImmunosuppresseur {
        return $this->conditionnementImmunosuppresseur;
    }

    public function setConditionnementImmunosuppresseur(?ConditionnementImmunosuppresseur $conditionnementImmunosuppresseur): static {
        $this->conditionnementImmunosuppresseur = $conditionnementImmunosuppresseur;

        return $this;
    }
}
