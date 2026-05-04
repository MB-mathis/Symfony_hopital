<?php

namespace App\State\Patient;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\PatientRepository;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\User;

final class PatientCollectionProvider implements ProviderInterface
{
    public function __construct(
        private PatientRepository $patientRepository,
        private Security $security
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        /** @var User|null $user */
        $user = $this->security->getUser();

        // 🔐 Sécurité API (important pour ton BTS + API Platform)
        if (!$user instanceof User) {
            return [];
        }

        // 📌 Utilisation de ta logique métier existante (TRÈS BON POINT)
        return $this->patientRepository->findPatientsByUser($user);
    }
}