<?php

namespace App\Service;

use App\Entity\Donneur;
use App\Model\DonneurTemplate;
use App\Repository\DonneurRepository;
use App\Enum\TypeDonneur;
use Doctrine\ORM\EntityManagerInterface;
use App\Enum\GroupeSanguin;
use App\Service\MedicalCalculatorService;

class DonneurService
{
    public function __construct(
        private DonneurRepository $donneurRepository,
        private EntityManagerInterface $em,
        private MedicalCalculatorService $calculator
    ) {}

    // -------------------
    // Récupération de donneurs
    // -------------------

    /** @return Donneur[] */
    public function getAllDonneurs(): array
    {
        return $this->donneurRepository->findAllDonneurs();
    }

    /** @return Donneur[] */
    public function getDonneursVivant(): array
    {
        return $this->donneurRepository->findDonneursVivant();
    }

    /** @return Donneur[] */
    public function getDonneursDecede(): array
    {
        return $this->donneurRepository->findDonneursDecede();
    }

    /** @return Donneur[] */
    public function getDonneursWithPrelevement(): array
    {
        return $this->donneurRepository->findDonneursWithPrelevement();
    }

    /** @return Donneur[] */
    public function getDonneursByGroupeSanguin(GroupeSanguin $groupe): array
    {
        return $this->donneurRepository->findDonneursByGroupeSanguin($groupe);
    }

    // -------------------
    // Hydratation / création d’un donneur
    // -------------------

    public function createDonneur(array $data): Donneur
    {
        $donneur = new Donneur();

        $donneur->setGroupeSanguin($data['groupeSanguin'] ?? null);
        $donneur->setSexe($data['sexe'] ?? null);
        $donneur->setDateNaissance($data['dateNaissance'] ?? null);
        $donneur->setTaille($data['taille'] ?? null);
        $donneur->setPoids($data['poids'] ?? null);
        $donneur->setTypeDonneur($data['typeDonneur'] ?? null);
        $donneur->setNumeroCrista($data['numeroCrista'] ?? null);

        // Nettoyer le JSON avant d’enregistrer
        $activeType = $data['typeDonneur'] ?? null;
        $donneur->setData($this->cleanData($data['data'] ?? DonneurTemplate::getDefaultData(), $activeType));

        // Calculs médicaux
        $this->calculator->calculate($donneur);

        $this->em->persist($donneur);
        $this->em->flush();

        return $donneur;
    }

    public function createDonneurVivant(array $data): Donneur
    {
        $data['typeDonneur'] = TypeDonneur::VIVANT;

        // Merge avec template
        $merged = array_replace_recursive(DonneurTemplate::getDefaultData(), $data['data'] ?? []);
        $merged[DonneurTemplate::KEY_VIVANT] = array_replace(
            $merged[DonneurTemplate::KEY_VIVANT],
            $data['data'][DonneurTemplate::KEY_VIVANT] ?? []
        );

        $data['data'] = $merged;

        return $this->createDonneur($data);
    }

    public function createDonneurDecede(array $data): Donneur
    {
        $data['typeDonneur'] = TypeDonneur::DECEDE;

        $merged = array_replace_recursive(DonneurTemplate::getDefaultData(), $data['data'] ?? []);
        $merged[DonneurTemplate::KEY_DECEDE] = array_replace(
            $merged[DonneurTemplate::KEY_DECEDE],
            $data['data'][DonneurTemplate::KEY_DECEDE] ?? []
        );

        $data['data'] = $merged;

        return $this->createDonneur($data);
    }

    // -------------------
    // Nettoyage JSON
    // -------------------

    /**
     * Supprime le bloc inactif et conserve le bloc actif même avec null
     */
    private function cleanData(array $data, ?TypeDonneur $activeType): array
    {
        if ($activeType === null) {
            return $data; // rien à nettoyer si type inconnu
        }

        // 1️⃣ Clés à garder toujours (communes)
        $keysToKeep = [
            'commentaire_patient',
            DonneurTemplate::KEY_GROUPAGE_HLA,
            DonneurTemplate::KEY_SEROLOGIE,
            DonneurTemplate::KEY_PRELEVEMENT,
            $activeType->value // le bloc spécifique du type actif
        ];

        $cleaned = [];

        // 2️⃣ On copie uniquement les clés à garder
        foreach ($keysToKeep as $key) {
            if (isset($data[$key])) {
                $cleaned[$key] = $data[$key];
            } else {
                // Si le bloc actif n’existe pas encore, on peut mettre un bloc vide avec null
                if ($key === $activeType->value) {
                    $cleaned[$key] = DonneurTemplate::getDefaultData()[$key];
                }
            }
        }

        return $cleaned;
    }
    
    // -------------------
    // Mise à jour du JSON data
    // -------------------

    public function updateData(Donneur $donneur, array $newData): Donneur
    {
        $data = $donneur->getData();
        $donneur->setData(array_merge($data, $newData));

         // Recalcul automatique
        $this->calculator->calculate($donneur);


        $this->em->flush();

        return $donneur;
    }

    // -------------------
    // Méthodes utilitaires
    // -------------------

    /** Retourne la clé JSON à utiliser selon le type */
    public function getDataKeyFromType(TypeDonneur $type): string
    {
        return $type === TypeDonneur::VIVANT
            ? DonneurTemplate::KEY_VIVANT
            : DonneurTemplate::KEY_DECEDE;
    }

    /** Récupère un donneur par ID ou null */
    public function getDonneurById(int $id): ?Donneur
    {
        return $this->donneurRepository->findDonneurById($id);
    }

    /** Récupère un donneur par numéro CRISTA */
    public function getDonneurByNumeroCrista(string $numero): ?Donneur
    {
        return $this->donneurRepository->findDonneurByNumeroCrista($numero);
    }
}