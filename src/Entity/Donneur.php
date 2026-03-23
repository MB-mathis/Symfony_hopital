<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\GroupeSanguin;
use App\Enum\Sexe;
use App\Enum\TypeDonneur;
use App\Repository\DonneurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: DonneurRepository::class)]
#[ApiResource]
class Donneur {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: GroupeSanguin::class)]
    private ?GroupeSanguin $groupeSanguin = null;

    #[ORM\Column(enumType: Sexe::class)]
    private ?Sexe $sexe = null;

    #[ORM\Column(nullable: true)]
    private ?float $taille = null;

    #[ORM\Column]
    private array $data = [];

    #[ORM\Column(enumType: TypeDonneur::class)]
    private ?TypeDonneur $typeDonneur = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateNaissance = null;

    #[ORM\Column(nullable: true)]
    private ?float $poids = null;

    #[ORM\Column]
    #[Gedmo\Timestampable(on: 'create')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Gedmo\Timestampable(on: 'update')]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $numeroCrista = null;

    /**
     * @var Collection<int, Greffe>
     */
    #[ORM\OneToMany(targetEntity: Greffe::class, mappedBy: 'donneur')]
    private Collection $greffes;

    #[ORM\Column(nullable: true)]
    private ?float $imc = null;

    #[ORM\Column(nullable: true)]
    private ?float $dfg = null;

    #[ORM\Column(nullable: true)]
    private ?float $clairanceCalculée = null;

    public function __construct()
    {
        $this->greffes = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getGroupeSanguin(): ?GroupeSanguin {
        return $this->groupeSanguin;
    }

    public function setGroupeSanguin(GroupeSanguin $groupeSanguin): static {
        $this->groupeSanguin = $groupeSanguin;

        return $this;
    }

    public function getSexe(): ?Sexe {
        return $this->sexe;
    }

    public function setSexe(Sexe $sexe): static {
        $this->sexe = $sexe;

        return $this;
    }

    public function getTaille(): ?float {
        return $this->taille;
    }

    public function setTaille(float $taille): static {
        $this->taille = $taille;

        return $this;
    }

    public function getData(): array {
        return $this->data;
    }

    public function setData(array $data): static {
        $this->data = $data;

        return $this;
    }

    public function getTypeDonneur(): ?TypeDonneur {
        return $this->typeDonneur;
    }

    public function setTypeDonneur(TypeDonneur $typeDonneur): static {
        $this->typeDonneur = $typeDonneur;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeImmutable {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeImmutable $dateNaissance): static {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getPoids(): ?float {
        return $this->poids;
    }

    public function setPoids(?float $poids): static {
        $this->poids = $poids;

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

    public function getNumeroCrista(): ?string {
        return $this->numeroCrista;
    }

    public function setNumeroCrista(string $numeroCrista): static {
        $this->numeroCrista = $numeroCrista;

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
            $greffe->setDonneur($this);
        }

        return $this;
    }

    public function removeGreffe(Greffe $greffe): static
    {
        if ($this->greffes->removeElement($greffe)) {
            // set the owning side to null (unless already changed)
            if ($greffe->getDonneur() === $this) {
                $greffe->setDonneur(null);
            }
        }

        return $this;
    }

    public function getImc(): ?float
    {
        return $this->imc;
    }

    public function setImc(?float $imc): static
    {
        $this->imc = $imc;

        return $this;
    }

    public function getDfg(): ?float
    {
        return $this->dfg;
    }

    public function setDfg(?float $dfg): static
    {
        $this->dfg = $dfg;

        return $this;
    }

    public function getClairanceCalculée(): ?float
    {
        return $this->clairanceCalculée;
    }

    public function setClairanceCalculée(?float $clairanceCalculée): static
    {
        $this->clairanceCalculée = $clairanceCalculée;

        return $this;
    }
}
