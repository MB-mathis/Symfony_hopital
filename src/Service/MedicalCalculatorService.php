<?php

namespace App\Service;

use App\Entity\Donneur;
use App\Enum\Sexe;
use App\Enum\TypeDonneur;
use App\Model\DonneurTemplate;


class MedicalCalculatorService
{

    /**
     * Calcule l'IMC, le DFG et la clairance calculée pour un donneur.
     */
    public function calculate(Donneur $donneur): Donneur
    {
        $typeKey = $donneur->getTypeDonneur() === TypeDonneur::VIVANT
            ? DonneurTemplate::KEY_VIVANT
            : DonneurTemplate::KEY_DECEDE;
        $data = $donneur->getData();

        // -----------------------
        // IMC
        // -----------------------
        $poids = $donneur->getPoids();
        $taille = $donneur->getTaille();

        if ($poids && $taille) {
            $imc = $poids / ($taille ** 2);
            $donneur->setImc(round($imc, 2));
        }

        // -----------------------
        // Créatinine selon le type
        // -----------------------
        $creatinine = null;
        if ($donneur->getTypeDonneur() === TypeDonneur::VIVANT) {
            $creatinine = $data[$typeKey]['creatinine'] ?? null;
        } else { // DECEDE
            $creatinine = $data[$typeKey]['creatinine_prelevement'] ?? null;
        }

        if ($creatinine && $donneur->getDateNaissance() && $donneur->getSexe()) {
            $age = $this->calculateAge($donneur->getDateNaissance());

            // -----------------------
            // DFG (MDRD simplifiée)
            // -----------------------
            $dfg = 175 * ( $creatinine / 88.4 ) ** (-1.154) * ($age ** -0.203);
            if ($donneur->getSexe() === Sexe::F) {
                $dfg *= 0.742;
            }
            $donneur->setDfg(round($dfg, 2));

            // -----------------------
            // Clairance calculée (Cockcroft-Gault simplifiée)
            // -----------------------
            $clairance = 186 * (($creatinine * 0.0113) ** -1.154) * ($age ** -0.203);
            if ($donneur->getSexe() === Sexe::F) {
                $clairance *= 0.742;
            }
            $donneur->setClairanceCalculee(round($clairance, 2));
        }

        return $donneur;
    }

    /**
     * Calcule l'âge en années à partir d'une date de naissance.
     */
    private function calculateAge(\DateTimeImmutable $dateNaissance): int
    {
        $today = new \DateTimeImmutable();
        $age = $today->diff($dateNaissance)->y;
        return $age;
    }
}