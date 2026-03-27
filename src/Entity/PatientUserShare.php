<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PatientUserShareRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatientUserShareRepository::class)]
#[ApiResource]
class PatientUserShare {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'patientUserShares')]
    private ?Patient $patient = null;

    #[ORM\ManyToOne(inversedBy: 'patientUserShares')]
    private ?User $user = null;

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

    public function getUser(): ?User {
        return $this->user;
    }

    public function setUser(?User $user): static {
        $this->user = $user;

        return $this;
    }
}
