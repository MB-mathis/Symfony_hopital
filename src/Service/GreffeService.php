<?php

namespace App\Service;

use App\Entity\Chirurgien;
use App\Entity\Greffe;
use App\Entity\DossierMedical;
use App\Entity\GroupeHLA;
use App\Entity\Serologie;
use App\Entity\Prelevement;
use App\Entity\ConditionnementImmunologique;
use App\Entity\Donneur;
use App\Repository\GreffeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use TypeGreffe;
use App\Enum\ConditionnementImmunosuppresseur;
use App\Enum\RisqueImmunologique;
use App\Enum\TypeEn;
use App\Enum\StatutVirologiqueToxo;
use App\Enum\StatutVirologiqueDR;


class GreffeService
{
    public function __construct(
        private EntityManagerInterface $em,
        private GreffeRepository $greffeRepository,
        private ValidatorInterface $validator
    ) {}

    // ============================
    // CRUD principal
    // ============================

    public function createGreffe(DossierMedical $dossier, Donneur $donneur, Chirurgien $chirurgien, array $data): Greffe
    {
        $this->validateGreffeData($data, $dossier);

        if ($this->greffeRepository->countByDossier($dossier) >= 2) {
            throw new \DomainException('Maximum 2 greffes autorisées pour ce dossier.');
        }

        $greffe = new Greffe();
        $greffe->setDossierMedical($dossier);
        $greffe->setDonneur($donneur);
        $greffe->setChirurgien($chirurgien);

        $this->hydrateGreffe($greffe, $data);
        $this->upsertSousEntites($greffe, $data);

        $this->em->persist($greffe);
        $this->em->flush();

        return $greffe;
    }

    public function updateGreffe(Greffe $greffe, array $data): Greffe
    {
        $this->validateGreffeData($data, $greffe->getDossierMedical());

        $this->hydrateGreffe($greffe, $data);
        $this->upsertSousEntites($greffe, $data);

        $this->em->flush();

        return $greffe;
    }

    public function removeGreffe(Greffe $greffe): void
    {
        $this->em->remove($greffe);
        $this->em->flush();
    }

    // ============================
    // Hydratation principale
    // ============================

    private function hydrateGreffe(Greffe $greffe, array $data): void
    {
        // Conversion dateGreffe vers DateTimeImmutable si besoin
        if (!empty($data['dateGreffe'])) {
            $greffe->setDateGreffe(
                $data['dateGreffe'] instanceof \DateTimeImmutable
                    ? $data['dateGreffe']
                    : \DateTimeImmutable::createFromMutable($data['dateGreffe'])
            );
        }

        $greffe->setRangGreffe($data['rangGreffe'] ?? $greffe->getRangGreffe());
        $greffe->setGreffonFonctionnel($data['greffonFonctionnel'] ?? $greffe->isGreffonFonctionnel());
        $greffe->setDialyse($data['dialyse'] ?? $greffe->isDialyse());

        if (!empty($data['typeGreffe']) && $data['typeGreffe'] instanceof TypeGreffe) {
            $greffe->setTypeGreffe($data['typeGreffe']);
        }

        if ($greffe->isGreffonFonctionnel()) {
            $greffe->setDateFinFonctionGreffon(null);
            $greffe->setCauseFinFonctionGreffon(null);
        } else {
            if (!empty($data['dateFinFonctionGreffon'])) {
                $greffe->setDateFinFonctionGreffon(
                    $data['dateFinFonctionGreffon'] instanceof \DateTimeImmutable
                        ? $data['dateFinFonctionGreffon']
                        : \DateTimeImmutable::createFromMutable($data['dateFinFonctionGreffon'])
                );
            }
            $greffe->setCauseFinFonctionGreffon($data['causeFinFonctionGreffon'] ?? $greffe->getCauseFinFonctionGreffon());
        }
    }

    // ============================
    // Gestion sous-entités
    // ============================

    private function upsertSousEntites(Greffe $greffe, array $data): void
    {
        $this->upsertGroupeHLA($greffe, $data['groupeHLA'] ?? []);
        $this->upsertSerologie($greffe, $data['serologie'] ?? []);
        $this->upsertPrelevement($greffe, $data['prelevement'] ?? []);
        $this->upsertConditionnement($greffe, $data['conditionnement'] ?? []);
    }

    private function upsertGroupeHLA(Greffe $greffe, array $data): void
    {
        $hla = $greffe->getGroupeHLA() ?? new GroupeHLA();
        $hla->setHlaAMismatch($data['hlaAMismatch'] ?? 0);
        $hla->setHlaBMismatch($data['hlaBMismatch'] ?? 0);
        $hla->setHlaCwMismatch($data['hlaCwMismatch'] ?? 0);
        $hla->setHlaDQMismatch($data['hlaDQMismatch'] ?? 0);
        $hla->setHlaDPMismatch($data['hlaDPMismatch'] ?? 0);
        $hla->setGreffe($greffe);
        $greffe->setGroupeHLA($hla);
    }

    private function upsertSerologie(Greffe $greffe, array $data): void
    {
        $sero = $greffe->getSerologie() ?? new Serologie();
        
        // Conversion pour cmvStatus
        if (!empty($data['cmvStatus'])) {
            $cmvEnum = StatutVirologiqueDR::tryFrom($data['cmvStatus']);
            if ($cmvEnum === null) {
                throw new \DomainException('Statut CMV invalide : ' . $data['cmvStatus']);
            }
            $sero->setCmvStatus($cmvEnum);
        } else {
            $sero->setCmvStatus(null);
        }
        
        // Conversion pour ebvStatus
        if (!empty($data['ebvStatus'])) {
            $ebvEnum = StatutVirologiqueDR::tryFrom($data['ebvStatus']);
            if ($ebvEnum === null) {
                throw new \DomainException('Statut EBV invalide : ' . $data['ebvStatus']);
            }
            $sero->setEbvStatus($ebvEnum);
        } else {
            $sero->setEbvStatus(null);
        }
        
        // Pour toxoStatus, c'est déjà géré
        if (!empty($data['toxoStatus']) && $data['toxoStatus'] instanceof StatutVirologiqueToxo) {
            $sero->setToxoStatus($data['toxoStatus']);
        }
        
        $sero->setGreffe($greffe);
        $greffe->setSerologie($sero);
    }

    private function upsertPrelevement(Greffe $greffe, array $data): void
    {
        $prelev = $greffe->getPrelevement() ?? new Prelevement();
       if (!empty($data['heureDeclampage'])) {
            if (is_string($data['heureDeclampage'])) {
                $prelev->setHeureDeclampage(\DateTime::createFromFormat('H:i:s', $data['heureDeclampage']));
            } else {
                $prelev->setHeureDeclampage($data['heureDeclampage']);
            }
        } else {
            $prelev->setHeureDeclampage(null);
        }
        $prelev->setCotePrelevement($data['cotePrelevement'] ?? null);
        $prelev->setCoteTransplantation($data['coteTransplantation'] ?? null);
        if (!empty($data['en']) && $data['en'] instanceof TypeEn) {
            $prelev->setEn($data['en']);
        }
        
        if (!empty($data['ischemieTotale']) && is_int($data['ischemieTotale'])) {
            $hours = floor($data['ischemieTotale'] / 60);
            $minutes = $data['ischemieTotale'] % 60;
            $prelev->setIschemieTotale(new \DateTime(sprintf('%02d:%02d:00', $hours, $minutes)));
        } else {
            $prelev->setIschemieTotale($data['ischemieTotale'] ?? null);
}
        $prelev->setDureeAnastomoses($data['dureeAnastomoses'] ?? null);
        $prelev->setSondeJJ($data['sondeJJ'] ?? null);
        $prelev->setCommentairePrelevement($data['commentairePrelevement'] ?? null);
        $prelev->setGreffe($greffe);
        $greffe->setPrelevement($prelev);
    }

    private function upsertConditionnement(Greffe $greffe, array $data): void
    {
        $cond = $greffe->getConditionnementImmunologique() ?? new ConditionnementImmunologique();
        if (!empty($data['risqueImmunologique']) && $data['risqueImmunologique'] instanceof RisqueImmunologique) {
            $cond->setRisqueImmunologique($data['risqueImmunologique']);
        }
        if (!empty($data['conditionnementImmunosuppresseur']) && $data['conditionnementImmunosuppresseur'] instanceof ConditionnementImmunosuppresseur) {
            $cond->setConditionnementImmunosuppresseur($data['conditionnementImmunosuppresseur']);
        }
        $cond->setCommentaireRisqueImmunologique($data['commentaireRisqueImmunologique'] ?? null);
        $cond->setCommentaireConditionnement($data['commentaireConditionnement'] ?? null);
        $cond->setGreffe($greffe);
        $greffe->setConditionnementImmunologique($cond);
    }

    // ============================
    // Validation stricte
    // ============================

    private function validateGreffeData(array $data, ?DossierMedical $dossier = null): void
    {
        if (empty($data['rangGreffe'])) {
            throw new \DomainException('Le rang de la greffe est obligatoire.');
        }

        if ($dossier && $this->greffeRepository->existsByDossierAndRang($dossier, $data['rangGreffe'])) {
            throw new \DomainException('Ce rang de greffe existe déjà pour ce dossier.');
        }

        if (($data['greffonFonctionnel'] ?? false) === false && empty($data['commentaireGreffe'])) {
            throw new \DomainException('Commentaire obligatoire si greffon non fonctionnel.');
        }

        if (($data['greffonFonctionnel'] ?? true) === true) {
            if (!empty($data['dateFinFonctionGreffon']) || !empty($data['causeFinFonctionGreffon'])) {
                throw new \DomainException('Les champs de fin de fonction ne peuvent être saisis que si le greffon est fonctionnel.');
            }
        }

        if (!empty($data['typeGreffe']) && !$data['typeGreffe'] instanceof TypeGreffe) {
            throw new \DomainException('Type de greffe invalide.');
        }

        if (!empty($data['conditionnement']['conditionnementImmunosuppresseur'])
            && !$data['conditionnement']['conditionnementImmunosuppresseur'] instanceof ConditionnementImmunosuppresseur) {
            throw new \DomainException('Conditionnement immunosuppresseur invalide.');
        }

        if (!empty($data['conditionnement']['risqueImmunologique'])
            && !$data['conditionnement']['risqueImmunologique'] instanceof RisqueImmunologique) {
            throw new \DomainException('Risque immunologique invalide.');
        }

        if (!empty($data['prelevement']['en'])
            && !$data['prelevement']['en'] instanceof TypeEn) {
            throw new \DomainException('Type EN invalide.');
        }

        if (!empty($data['serologie']['toxoStatus'])
            && !$data['serologie']['toxoStatus'] instanceof StatutVirologiqueToxo) {
            throw new \DomainException('Statut virologique Toxo invalide.');
        }
    }

    // ============================
    // Méthodes utilitaires
    // ============================

    public function getGreffesByDossierWithFilters(DossierMedical $dossier, array $filters = []): array
    {
        return $this->greffeRepository->findByDossierWithFilters($dossier, $filters);
    }
}