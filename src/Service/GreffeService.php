<?php

namespace App\Service;

use App\Entity\Greffe;
use App\Entity\DossierMedical;
use App\Entity\GroupeHLA;
use App\Entity\Serologie;
use App\Entity\Prelevement;
use App\Entity\ConditionnementImmunologique;
use App\Repository\GreffeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Enum\TypeGreffe;
use App\Enum\ConditionnementImmunosuppresseur;
use App\Enum\RisqueImmunologique;
use App\Enum\TypeEn;
use App\Enum\StatutVirologiqueToxo;

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

    public function createGreffe(DossierMedical $dossier, array $data): Greffe
    {
        $this->validateGreffeData($data, $dossier);

        $greffe = new Greffe();
        $greffe->setDossierMedical($dossier);

        $this->hydrateGreffe($greffe, $data);

        // Création des sous-entités
        $this->createGroupeHLA($greffe, $data['groupeHLA'] ?? []);
        $this->createSerologie($greffe, $data['serologie'] ?? []);
        $this->createPrelevement($greffe, $data['prelevement'] ?? []);
        $this->createConditionnement($greffe, $data['conditionnement'] ?? []);

        $this->em->persist($greffe);
        $this->em->flush();

        return $greffe;
    }

    public function updateGreffe(Greffe $greffe, array $data): Greffe
    {
        $this->validateGreffeData($data, $greffe->getDossierMedical());

        $this->hydrateGreffe($greffe, $data);

        if (!empty($data['groupeHLA'])) $this->createGroupeHLA($greffe, $data['groupeHLA']);
        if (!empty($data['serologie'])) $this->createSerologie($greffe, $data['serologie']);
        if (!empty($data['prelevement'])) $this->createPrelevement($greffe, $data['prelevement']);
        if (!empty($data['conditionnement'])) $this->createConditionnement($greffe, $data['conditionnement']);

        $this->em->flush();

        return $greffe;
    }

    public function removeGreffe(Greffe $greffe): void
    {
        $this->em->remove($greffe);
        $this->em->flush();
    }

    // ============================
    // Hydratation
    // ============================

    private function hydrateGreffe(Greffe $greffe, array $data): void
    {
        $greffe->setDateGreffe($data['dateGreffe'] ?? $greffe->getDateGreffe());
        $greffe->setRangGreffe($data['rangGreffe'] ?? $greffe->getRangGreffe());
        $greffe->setGreffonFonctionnel($data['greffonFonctionnel'] ?? $greffe->isGreffonFonctionnel());
        $greffe->setDialyse($data['dialyse'] ?? $greffe->isDialyse());
        $greffe->setCommentaireGreffe($data['commentaireGreffe'] ?? $greffe->getCommentaireGreffe());

        if (!empty($data['typeGreffe']) && $data['typeGreffe'] instanceof TypeGreffe) {
            $greffe->setTypeGreffe($data['typeGreffe']);
        }

        // Gestion stricte de la fin de fonction du greffon
        if ($greffe->isGreffonFonctionnel()) {
            $greffe->setDateFinFonctionGreffon(null);
            $greffe->setCauseFinFonctionGreffon(null);
        } else {
            $greffe->setDateFinFonctionGreffon($data['dateFinFonctionGreffon'] ?? $greffe->getDateFinFonctionGreffon());
            $greffe->setCauseFinFonctionGreffon($data['causeFinFonctionGreffon'] ?? $greffe->getCauseFinFonctionGreffon());
        }
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

        // Validation de date/cause fin fonction greffon
        if (($data['greffonFonctionnel'] ?? true) === true) {
            if (!empty($data['dateFinFonctionGreffon']) || !empty($data['causeFinFonctionGreffon'])) {
                throw new \DomainException('Les champs de fin de fonction ne peuvent être saisis que si le greffon n’est pas fonctionnel.');
            }
        }

        // Vérification des enums
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
    // Sous-entités
    // ============================

    private function createGroupeHLA(Greffe $greffe, array $data): void
    {
        $hla = new GroupeHLA();
        $hla->setHlaAMismatch($data['hlaAMismatch'] ?? 0);
        $hla->setHlaBMismatch($data['hlaBMismatch'] ?? 0);
        $hla->setHlaCwMismatch($data['hlaCwMismatch'] ?? null);
        $hla->setHlaDQMismatch($data['hlaDQMismatch'] ?? 0);
        $hla->setHlaDPMismatch($data['hlaDPMismatch'] ?? null);
        $hla->setGreffe($greffe);
        $greffe->setGroupeHLA($hla);
    }

    private function createSerologie(Greffe $greffe, array $data): void
    {
        $sero = new Serologie();
        $sero->setCmvStatus($data['cmvStatus'] ?? null);
        $sero->setEbvStatus($data['ebvStatus'] ?? null);

        if (!empty($data['toxoStatus']) && $data['toxoStatus'] instanceof StatutVirologiqueToxo) {
            $sero->setToxoStatus($data['toxoStatus']);
        }

        $sero->setGreffe($greffe);
        $greffe->setSerologie($sero);
    }

    private function createPrelevement(Greffe $greffe, array $data): void
    {
        $prelev = new Prelevement();
        $prelev->setDateDeclampage($data['dateDeclampage'] ?? null);
        $prelev->setHeureDeclampage($data['heureDeclampage'] ?? null);
        $prelev->setCotePrelevement($data['cotePrelevement'] ?? null);
        $prelev->setCoteTransplantation($data['coteTransplantation'] ?? null);

        if (!empty($data['en']) && $data['en'] instanceof TypeEn) {
            $prelev->setEn($data['en']);
        }

        $prelev->setIschemieTotale($data['ischemieTotale'] ?? null);
        $prelev->setDureeAnastomoses($data['dureeAnastomoses'] ?? null);
        $prelev->setSondeJJ($data['sondeJJ'] ?? null);
        $prelev->setCommentairePrelevement($data['commentairePrelevement'] ?? null);

        $prelev->setGreffe($greffe);
        $greffe->setPrelevement($prelev);
    }

    private function createConditionnement(Greffe $greffe, array $data): void
    {
        $cond = new ConditionnementImmunologique();

        if (!empty($data['risqueImmunologique']) && $data['risqueImmunologique'] instanceof RisqueImmunologique) {
            $cond->setRisqueImmunologique($data['risqueImmunologique']);
        }

        if (!empty($data['conditionnementImmunosuppresseur'])
            && $data['conditionnementImmunosuppresseur'] instanceof ConditionnementImmunosuppresseur) {
            $cond->setConditionnementImmunosuppresseur($data['conditionnementImmunosuppresseur']);
        }

        $cond->setCommentaireRisqueImmunologique($data['commentaireRisqueImmunologique'] ?? null);
        $cond->setCommentaireConditionnement($data['commentaireConditionnement'] ?? null);

        $cond->setGreffe($greffe);
        $greffe->setConditionnementImmunologique($cond);
    }

    // ============================
    // Méthodes utilitaires
    // ============================

    // public function getGreffesByPatient($patient): array
    // {
    //     return $this->greffeRepository->findGreffesByPatient($patient);
    // }

    public function getGreffesByDossierWithFilters(DossierMedical $dossier, array $filters = []): array
    {
        return $this->greffeRepository->findByDossierWithFilters($dossier, $filters);
    }

    // public function getMaxRang(DossierMedical $dossier): ?int
    // {
    //     return $this->greffeRepository->findMaxRangByDossier($dossier);
    // }
}