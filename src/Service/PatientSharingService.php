<?php
// src/Service/PatientSharingService.php

namespace App\Service;

use App\Entity\Patient;
use App\Entity\User;
use App\Entity\PatientUserShare;

class PatientSharingService
{
    public function __construct(
        private PatientAccessService $accessService
    ) {}

    // ========================
    // PUBLIC API
    // ========================

    /**
     * 🔁 Mise à jour complète (formulaire)
     */
    public function updateSharing(User $actor, Patient $patient, iterable $newUsers): void
    {
        $this->denyAccessIfCannotShare($actor, $patient);

        // 🔥 Supprime tous les partages sauf le propriétaire
        $this->clearSharingExceptOwner($patient);

        foreach ($newUsers as $user) {
            $this->share($patient, $user);
        }

        $this->ensureOwnerAlwaysPresent($patient);
    }

    /**
     * ➕ Ajouter un accès
     */
    public function shareWith(User $actor, Patient $patient, User $target): void
    {
        $this->denyAccessIfCannotShare($actor, $patient);
        $this->share($patient, $target);
    }

    /**
     * ➖ Retirer un accès
     */
    public function unshareWith(User $actor, Patient $patient, User $target): void
    {
        $this->denyAccessIfCannotShare($actor, $patient);

        if ($this->isOwner($patient, $target)) {
            throw new \LogicException('Impossible de retirer le créateur.');
        }

        $this->unshare($patient, $target);
    }

    // ========================
    // HELPERS PRIVÉS
    // ========================

    private function denyAccessIfCannotShare(User $actor, Patient $patient): void
    {
        if (!$this->accessService->canShare($actor, $patient)) {
            throw new \LogicException('Accès refusé au partage.');
        }
    }

    private function isOwner(Patient $patient, User $user): bool
    {
        return $patient->getCreatedBy() === $user;
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

    private function share(Patient $patient, User $user): void
    {
        if (!$this->isAlreadyShared($patient, $user)) {
            $share = new PatientUserShare();
            $share->setPatient($patient);
            $share->setUser($user);
            $patient->addPatientUserShare($share);
        }
    }

    private function unshare(Patient $patient, User $user): void
    {
        foreach ($patient->getPatientUserShares() as $share) {
            if ($share->getUser() === $user) {
                $patient->removePatientUserShare($share);
                break;
            }
        }
    }

    private function clearSharingExceptOwner(Patient $patient): void
    {
        foreach ($patient->getPatientUserShares() as $share) {
            if (!$this->isOwner($patient, $share->getUser())) {
                $patient->removePatientUserShare($share);
            }
        }
    }

    private function ensureOwnerAlwaysPresent(Patient $patient): void
    {
        $owner = $patient->getCreatedBy();
        if (!$this->isAlreadyShared($patient, $owner)) {
            $this->share($patient, $owner);
        }
    }
}