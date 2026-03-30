<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\StatutVirologiqueToxo;
use App\Repository\SerologieRepository;
use Doctrine\ORM\Mapping as ORM;
use StatutVirologiqueDR;

#[ORM\Entity(repositoryClass: SerologieRepository::class)]
#[ApiResource]
class Serologie {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true, enumType: StatutVirologiqueDR::class)]
    private ?StatutVirologiqueDR $cmvStatus = null;

    #[ORM\Column(nullable: true, enumType: StatutVirologiqueDR::class)]
    private ?StatutVirologiqueDR $ebvStatus = null;

    #[ORM\Column(nullable: true, enumType: StatutVirologiqueToxo::class)]
    private ?StatutVirologiqueToxo $toxoStatus = null;

    #[ORM\OneToOne(inversedBy: 'serologie', cascade: ['persist', 'remove'])]
    private ?Greffe $greffe = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getCmvStatus(): ?StatutVirologiqueDR {
        return $this->cmvStatus;
    }

    public function setCmvStatus(?StatutVirologiqueDR $cmvStatus): static {
        $this->cmvStatus = $cmvStatus;

        return $this;
    }

    public function getEbvStatus(): ?StatutVirologiqueDR {
        return $this->ebvStatus;
    }

    public function setEbvStatus(?StatutVirologiqueDR $ebvStatus): static {
        $this->ebvStatus = $ebvStatus;

        return $this;
    }

    public function getToxoStatus(): ?StatutVirologiqueToxo {
        return $this->toxoStatus;
    }

    public function setToxoStatus(?StatutVirologiqueToxo $toxoStatus): static {
        $this->toxoStatus = $toxoStatus;

        return $this;
    }

    public function getGreffe(): ?Greffe {
        return $this->greffe;
    }

    public function setGreffe(?Greffe $greffe): static {
        $this->greffe = $greffe;

        return $this;
    }
}
