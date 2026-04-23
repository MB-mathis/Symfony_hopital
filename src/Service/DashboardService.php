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
                'controller' => 'App\\Controller\\PatientController',
                'routes' => [
                    'list' => 'ROUTE_LIST',
                    'new' => 'ROUTE_CREATE',
                ],
            ],
            [
                'label' => 'Greffes',
                'icon' => 'heart',
                'controller' => 'App\\Controller\\GreffeController',
                'routes' => [
                    'list' => 'ROUTE_LIST',
                ],
            ],
            [
                'label' => 'Donneurs',
                'icon' => 'dna',
                'controller' => 'App\\Controller\\DonneurController',
                'routes' => [
                    'list' => 'ROUTE_LIST',
                    'new' => 'ROUTE_CREATE',
                ],
            ],
            [
                'label' => 'Dossiers médicaux',
                'icon' => 'file',
                'controller' => 'App\\Controller\\DossierMedicalController',
                'routes' => [
                    'list' => 'ROUTE_LIST',
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
                'controller' => 'App\\Controller\\ChirurgienController',
                'routes' => [
                    'list' => 'ROUTE_LIST',
                ],
            ],
        ];
    }
}