<?php

namespace App\Service;

use App\Repository\PatientRepository;
use App\Repository\GreffeRepository;
use App\Repository\DonneurRepository;
use App\Repository\ChirurgienRepository;
use App\Repository\UserRepository;

class DashboardService
{
    public function __construct(
        private PatientRepository $patientRepository,
        private GreffeRepository $greffeRepository,
        private DonneurRepository $donneurRepository,
        private ChirurgienRepository $chirurgienRepository,
        private UserRepository $userRepository
    ) {}

    public function getDashboardData(): array
    {
        return [
            'stats' => $this->getStats(),
            'modules' => $this->getModules(),
        ];
    }

    private function getStats(): array
    {
        return [
            'patients' => $this->patientRepository->countPatients(),
            'greffes' => $this->greffeRepository->countGreffes(),
            'donneurs' => $this->donneurRepository->countDonneurs(),
            'chirurgiens' => $this->chirurgienRepository->countChirurgiens(),
            'users' => $this->userRepository->countUsers(),
        ];
    }

    private function getModules(): array
    {
        return [
            [
                'label' => 'Patients',
                'icon' => 'user',
                'routes' => [
                    'list' => 'app_patient_index',
                    'new' => 'app_patient_new',
                ],
            ],
            [
                'label' => 'Greffes',
                'icon' => 'heart',
                'routes' => [
                    'list' => 'app_greffe_index',
                ],
            ],
            [
                'label' => 'Donneurs',
                'icon' => 'dna',
                'routes' => [
                    'list' => 'app_donneur_index',
                    'new' => 'app_donneur_new',
                ],
            ],
            [
                'label' => 'Dossiers médicaux',
                'icon' => 'file',
                'routes' => [
                    'list' => 'app_dossier_medical_index',
                ],
            ],
            [
                'label' => 'Utilisateurs',
                'icon' => 'users',
                'routes' => [
                    'list' => 'app_user_index',
                    'new' => 'app_user_new',
                ],
            ],
            [
                'label' => 'Chirurgiens',
                'icon' => 'user-md',
                'routes' => [
                    'list' => 'app_chirurgien_index',
                ],
            ],
        ];
    }
}