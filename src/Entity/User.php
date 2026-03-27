<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Gedmo\Mapping\Annotation as Gedmo;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column]
    #[Gedmo\Timestampable(on: 'create')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Gedmo\Timestampable(on: 'update')]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, DossierMedical>
     */
    #[ORM\OneToMany(targetEntity: DossierMedical::class, mappedBy: 'createdBy')]
    private Collection $dossierMedicals;

    /**
     * @var Collection<int, Patient>
     */
    #[ORM\OneToMany(targetEntity: Patient::class, mappedBy: 'createdBy')]
    private Collection $patients;

    /**
     * @var Collection<int, Document>
     */
    #[ORM\OneToMany(targetEntity: Document::class, mappedBy: 'uploadedBy')]
    private Collection $documents;

    /**
     * @var Collection<int, Consultation>
     */
    #[ORM\OneToMany(targetEntity: Consultation::class, mappedBy: 'user')]
    private Collection $consultations;

    /**
     * @var Collection<int, PatientUserShare>
     */
    #[ORM\OneToMany(targetEntity: PatientUserShare::class, mappedBy: 'user')]
    private Collection $patientUserShares;

    public function __construct() {
        $this->dossierMedicals = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->patients = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->consultations = new ArrayCollection();
        $this->patientUserShares = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(string $email): static {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string {
        return $this->password;
    }

    public function setPassword(string $password): static {
        $this->password = $password;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array {
        $data = (array) $this;
        $data["\0" . self::class . "\0password"] = hash('crc32c', $this->password);

        return $data;
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
     * @return Collection<int, DossierMedical>
     */
    public function getDossierMedicals(): Collection {
        return $this->dossierMedicals;
    }

    public function addDossierMedical(DossierMedical $dossierMedical): static {
        if (!$this->dossierMedicals->contains($dossierMedical)) {
            $this->dossierMedicals->add($dossierMedical);
            $dossierMedical->setCreatedBy($this);
        }

        return $this;
    }

    public function removeDossierMedical(DossierMedical $dossierMedical): static {
        if ($this->dossierMedicals->removeElement($dossierMedical)) {
            // set the owning side to null (unless already changed)
            if ($dossierMedical->getCreatedBy() === $this) {
                $dossierMedical->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Patient>
     */
    public function getPatients(): Collection
    {
        return $this->patients;
    }

    public function addPatient(Patient $patient): static
    {
        if (!$this->patients->contains($patient)) {
            $this->patients->add($patient);
            $patient->setCreatedBy($this);
        }

        return $this;
    }

    public function removePatient(Patient $patient): static
    {
        if ($this->patients->removeElement($patient)) {
            // set the owning side to null (unless already changed)
            if ($patient->getCreatedBy() === $this) {
                $patient->setCreatedBy(null);
            }
        }

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
            $document->setUploadedBy($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): static
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getUploadedBy() === $this) {
                $document->setUploadedBy(null);
            }
        }

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
            $consultation->setUser($this);
        }

        return $this;
    }

    public function removeConsultation(Consultation $consultation): static
    {
        if ($this->consultations->removeElement($consultation)) {
            // set the owning side to null (unless already changed)
            if ($consultation->getUser() === $this) {
                $consultation->setUser(null);
            }
        }

        return $this;
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
            $patientUserShare->setUser($this);
        }

        return $this;
    }

    public function removePatientUserShare(PatientUserShare $patientUserShare): static
    {
        if ($this->patientUserShares->removeElement($patientUserShare)) {
            // set the owning side to null (unless already changed)
            if ($patientUserShare->getUser() === $this) {
                $patientUserShare->setUser(null);
            }
        }

        return $this;
    }
}
