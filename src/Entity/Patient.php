<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\Sexe;
use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
#[ApiResource]
class Patient {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateNaissance = null;

    #[ORM\Column(type: Types::STRING, enumType: Sexe::class)]
    private ?Sexe $sexe = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(length: 255)]
    private ?string $codePostal = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column]
    #[Gedmo\Timestampable(on: 'create')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Gedmo\Timestampable(on: 'update')]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToOne(mappedBy: 'patient', cascade: ['persist', 'remove'])]
    private ?DossierMedical $dossierMedical = null;

    #[ORM\ManyToOne(inversedBy: 'patients')]
    #[ORM\JoinColumn(nullable: false)]
    #[Gedmo\Blameable(on: 'create')]
    private ?User $createdBy = null;

    #[ORM\ManyToOne(inversedBy: 'patients')]
    #[ORM\JoinColumn(nullable: true)]
    #[Gedmo\Blameable(on: 'update')]
    private ?User $updatedBy = null;

    /**
     * @var Collection<int, Consultation>
     */
    #[ORM\OneToMany(targetEntity: Consultation::class, mappedBy: 'patient')]
    private Collection $consultations;

    /**
     * @var Collection<int, PatientUserShare>
     */
    #[ORM\OneToMany(targetEntity: PatientUserShare::class, mappedBy: 'patient')]
    private Collection $patientUserShares;

    public function __construct() {
        $this->createdAt = new \DateTimeImmutable();
        $this->consultations = new ArrayCollection();
        $this->patientUserShares = new ArrayCollection();
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

    public function getDateNaissance(): ?\DateTime {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTime $dateNaissance): static {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getSexe(): ?Sexe {
        return $this->sexe;
    }

    public function setSexe(Sexe $sexe): static {
        $this->sexe = $sexe;

        return $this;
    }

    public function getVille(): ?string {
        return $this->ville;
    }

    public function setVille(string $ville): static {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?string {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): static {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getTelephone(): ?string {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(string $email): static {
        $this->email = $email;

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

    public function getDossierMedical(): ?DossierMedical {
        return $this->dossierMedical;
    }

    public function setDossierMedical(DossierMedical $dossierMedical): static {
        // set the owning side of the relation if necessary
        if ($dossierMedical->getPatient() !== $this) {
            $dossierMedical->setPatient($this);
        }

        $this->dossierMedical = $dossierMedical;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?User $updatedBy): static
    {
        $this->updatedBy = $updatedBy;

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
            $consultation->setPatient($this);
        }

        return $this;
    }

    public function removeConsultation(Consultation $consultation): static
    {
        if ($this->consultations->removeElement($consultation)) {
            // set the owning side to null (unless already changed)
            if ($consultation->getPatient() === $this) {
                $consultation->setPatient(null);
            }
        }

        return $this;
    }
    
    public function getAuthorizedUsers(): array
    {
        return $this->patientUserShares->map(fn($share) => $share->getUser())->toArray();
    }

    /**
     * @return Collection<int, PatientUserShare>
     */
    public function getPatientUserShares(): Collection
    {
        return $this->patientUserShares;
    }

    public function addPatientUserShare(PatientUserShare $patientUserShare): static
    {
        if (!$this->patientUserShares->contains($patientUserShare)) {
            $this->patientUserShares->add($patientUserShare);
            $patientUserShare->setPatient($this);
        }

        return $this;
    }

    public function removePatientUserShare(PatientUserShare $patientUserShare): static
    {
        if ($this->patientUserShares->removeElement($patientUserShare)) {
            // set the owning side to null (unless already changed)
            if ($patientUserShare->getPatient() === $this) {
                $patientUserShare->setPatient(null);
            }
        }

        return $this;
    }
}
