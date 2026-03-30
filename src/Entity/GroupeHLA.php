<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\GroupeHLARepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupeHLARepository::class)]
#[ApiResource]
class GroupeHLA {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'groupeHLA', cascade: ['persist', 'remove'])]
    private ?Greffe $greffe = null;

    #[ORM\Column]
    private ?int $hlaAMismatch = null;

    #[ORM\Column]
    private ?int $hlaBMismatch = null;

    #[ORM\Column(nullable: true)]
    private ?int $hlaCwMismatch = null;

    #[ORM\Column]
    private ?int $hlaDQMismatch = null;

    #[ORM\Column(nullable: true)]
    private ?int $hlaDPMismatch = null;

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

    public function getHlaAMismatch(): ?int {
        return $this->hlaAMismatch;
    }

    public function setHlaAMismatch(int $hlaAMismatch): static {
        $this->hlaAMismatch = $hlaAMismatch;

        return $this;
    }

    public function getHlaBMismatch(): ?int {
        return $this->hlaBMismatch;
    }

    public function setHlaBMismatch(int $hlaBMismatch): static {
        $this->hlaBMismatch = $hlaBMismatch;

        return $this;
    }

    public function getHlaCwMismatch(): ?int {
        return $this->hlaCwMismatch;
    }

    public function setHlaCwMismatch(int $hlaCwMismatch): static {
        $this->hlaCwMismatch = $hlaCwMismatch;

        return $this;
    }

    public function getHlaDQMismatch(): ?int {
        return $this->hlaDQMismatch;
    }

    public function setHlaDQMismatch(int $hlaDQMismatch): static {
        $this->hlaDQMismatch = $hlaDQMismatch;

        return $this;
    }

    public function getHlaDPMismatch(): ?int {
        return $this->hlaDPMismatch;
    }

    public function setHlaDPMismatch(?int $hlaDPMismatch): static {
        $this->hlaDPMismatch = $hlaDPMismatch;

        return $this;
    }
}
