<?php

namespace App\Security\Voter;

use App\Entity\Patient;
use App\Entity\User;
use App\Service\PatientShareService;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\Voter\Vote; // ajouté pour compatibilité

final class PatientVoter extends Voter
{
    public const VIEW   = 'view';
    public const EDIT   = 'edit';
    public const SHARE  = 'share';
    public const DELETE = 'delete';

    public function __construct(private PatientShareService $patientShareService) {}

    protected function supports(string $attribute, mixed $subject, ?Vote $vote = null): bool
    {
        return $subject instanceof Patient && in_array($attribute, [self::VIEW, self::EDIT, self::SHARE, self::DELETE]);
    }

    /**
     * @param Patient $subject
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        $patient = $subject;
        $user = $token->getUser();

        // sécurité: s'il n'y a pas d'utilisateur connecté
        if (!$user instanceof User) {
            return false;
        }

        return match ($attribute) {
        self::VIEW   => $this->patientShareService->canAccess($patient, $user),
        self::EDIT   => $this->patientShareService->canAccess($patient, $user),
        self::SHARE  => $this->patientShareService->canModifyShares($patient, $user),
        self::DELETE => $patient->getCreatedBy() === $user,
        };
    }
}