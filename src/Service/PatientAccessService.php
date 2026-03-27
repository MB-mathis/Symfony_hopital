<?php
// src/Service/PatientAccessService.php

namespace App\Service;

use App\Entity\Patient;
use App\Entity\User;

class PatientAccessService
{
    // ========================
    // PUBLIC API
    // ========================

    public function canView(User $user, Patient $patient): bool
    {
        return $this->isOwner($user, $patient)
            || $this->isSharedWith($user, $patient);
    }

    public function canEdit(User $user, Patient $patient): bool
    {
        // Pour l'instant, même règle que view
        return $this->canView($user, $patient);
    }

    /**
     * Un user peut partager le patient s’il peut le voir
     */
    public function canShare(User $user, Patient $patient): bool
    {
        return $this->canView($user, $patient);
    }

    public function canDelete(User $user, Patient $patient): bool
    {
        return $this->isOwner($user, $patient);
    }

    // ========================
    // HELPERS PRIVÉS
    // ========================

    private function isOwner(User $user, Patient $patient): bool
    {
        return $patient->getCreatedBy() === $user;
    }

    private function isSharedWith(User $user, Patient $patient): bool
    {
        return $this->isAlreadyShared($patient, $user);
    }

    private function isAlreadyShared(Patient $patient, User $user): bool
    {
        foreach ($patient->getPatientUserShares() as $share) {
            if ($share->getUser() === $user) {
                return true;
            }
        }
        return false;
    }
    // ou plus simplement avec une collection Doctrine :
    // private function isSharedWith(User $user, Patient $patient): bool
    // {
    //     // Utilise la méthode exists() de Doctrine Collection pour vérifier
    //     return $patient->getPatientUserShares()->exists(
    //         fn($key, $share) => $share->getUser() === $user
    //     );
    // }
}