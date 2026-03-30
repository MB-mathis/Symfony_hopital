<?php

namespace App\Service;

use App\Entity\Patient;
use App\Entity\User;
use App\Entity\PatientUserShare;

final class PatientShareService
{
    /**
     * Vérifie si un utilisateur a accès à un patient
     * (propriétaire ou utilisateur partagé).
     */
    public function canAccess(Patient $patient, User $user): bool
    {
        // Propriétaire = accès complet
        if ($patient->getCreatedBy() === $user) {
            return true;
        }

        // Vérifie les partages utilisateurs
        foreach ($patient->getPatientUserShares() as $share) {
            if ($share->getUser() === $user) {
                return true;
            }
        }

        return false;
    }

    /**
     * Retourne tous les utilisateurs ayant accès au patient
     * (propriétaire + utilisateurs partagés).
     *
     * @return User[]
     */
    public function getAuthorizedUsers(Patient $patient): array
    {
        $users = [];

        // Partages utilisateurs
        foreach ($patient->getPatientUserShares() as $share) {
            $users[$share->getUser()->getId()] = $share->getUser();
        }

        // Ajoute toujours le créateur
        if ($patient->getCreatedBy()) {
            $users[$patient->getCreatedBy()->getId()] = $patient->getCreatedBy();
        }

        return array_values($users);
    }

    /**
     * Retourne les partages visibles pour un utilisateur donné (Twig).
     *
     * @return array{label: string}[]
     */
    public function getVisibleSharesForUser(Patient $patient, User $user): array
    {
        $shares = [];
        $isCreator = $patient->getCreatedBy() === $user;

        foreach ($patient->getPatientUserShares() as $share) {
            if ($isCreator || true) { // tout le monde voit les partages, le front ne permet d'agir que si créateur
                $shares[] = [
                    'label' => $share->getUser()->getFirstname() . ' ' . $share->getUser()->getLastname(),
                ];
            }
        }

        return $shares;
    }

    /**
     * Ajoute un partage en délégant à l'entité.
     */
    public function addShare(Patient $patient, PatientUserShare $share, User $currentUser): void
    {
        $patient->addPatientUserShare($share, $currentUser);
    }

    /**
     * Supprime un partage en délégant à l'entité.
     */
    public function removeShare(Patient $patient, PatientUserShare $share, User $currentUser): void
    {
        $patient->removePatientUserShare($share, $currentUser);
    }

    /**
     * Vérifie si l'utilisateur peut modifier les partages
     */
    public function canModifyShares(Patient $patient, User $user): bool
    {
        return $patient->getCreatedBy() === $user;
    }
}