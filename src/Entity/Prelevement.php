<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\CoteRein;
use App\Enum\TypeEn;
use App\Repository\PrelevementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrelevementRepository::class)]
#[ApiResource]
class Prelevement {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'prelevement', cascade: ['persist', 'remove'])]
    private ?Greffe $greffe = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $dateDeclampage = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTime $heureDeclampage = null;

    #[ORM\Column(nullable: true, enumType: CoteRein::class)]
    private ?CoteRein $cotePrelevement = null;

    #[ORM\Column(nullable: true, enumType: CoteRein::class)]
    private ?CoteRein $coteTransplantation = null;

    #[ORM\Column(nullable: true, enumType: TypeEn::class)]
    private ?TypeEn $en = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTime $ischemieTotale = null;

    #[ORM\Column(nullable: true)]
    private ?int $dureeAnastomoses = null;

    #[ORM\Column(nullable: true)]
    private ?bool $sondeJJ = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentairePrelevement = null;

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

    public function getDateDeclampage(): ?\DateTime {
        return $this->dateDeclampage;
    }

    public function setDateDeclampage(?\DateTime $dateDeclampage): static {
        $this->dateDeclampage = $dateDeclampage;

        return $this;
    }

    public function getHeureDeclampage(): ?\DateTime {
        return $this->heureDeclampage;
    }

    public function setHeureDeclampage(?\DateTime $heureDeclampage): static {
        $this->heureDeclampage = $heureDeclampage;

        return $this;
    }

    public function getCotePrelevement(): ?CoteRein {
        return $this->cotePrelevement;
    }

    public function setCotePrelevement(?CoteRein $cotePrelevement): static {
        $this->cotePrelevement = $cotePrelevement;

        return $this;
    }

    public function getCoteTransplantation(): ?CoteRein {
        return $this->coteTransplantation;
    }

    public function setCoteTransplantation(?CoteRein $coteTransplantation): static {
        $this->coteTransplantation = $coteTransplantation;

        return $this;
    }

    public function getEn(): ?TypeEn {
        return $this->en;
    }

    public function setEn(?TypeEn $en): static {
        $this->en = $en;

        return $this;
    }

    public function getIschemieTotale(): ?\DateTime {
        return $this->ischemieTotale;
    }

    public function setIschemieTotale(?\DateTime $ischemieTotale): static {
        $this->ischemieTotale = $ischemieTotale;

        return $this;
    }

    public function getDureeAnastomoses(): ?int {
        return $this->dureeAnastomoses;
    }

    public function setDureeAnastomoses(?int $dureeAnastomoses): static {
        $this->dureeAnastomoses = $dureeAnastomoses;

        return $this;
    }

    public function isSondeJJ(): ?bool {
        return $this->sondeJJ;
    }

    public function setSondeJJ(?bool $sondeJJ): static {
        $this->sondeJJ = $sondeJJ;

        return $this;
    }

    public function getCommentairePrelevement(): ?string {
        return $this->commentairePrelevement;
    }

    public function setCommentairePrelevement(?string $commentairePrelevement): static {
        $this->commentairePrelevement = $commentairePrelevement;

        return $this;
    }
}
