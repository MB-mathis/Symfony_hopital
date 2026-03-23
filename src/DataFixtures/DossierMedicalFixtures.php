<?php

namespace App\DataFixtures;

use App\Entity\DossierMedical;
use App\Entity\Patient;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\User;


class DossierMedicalFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Récupérer tous les patients déjà créés
        $patients = $manager->getRepository(Patient::class)->findAll();

        // Récupérer les utilisateurs de référence
        $userMedical = $this->getReference('user_medical', User::class);
        $userNephrologue = $this->getReference('user_nephrologue', User::class);

        foreach ($patients as $patient) {
            $dossier = new DossierMedical();
            $dossier->setPatient($patient);

            // Choix aléatoire du créateur du dossier entre medical et nephrologue
            $createdBy = $this->getFaker()->boolean(50) ? $userMedical : $userNephrologue;
            $dossier->setCreatedBy($createdBy);

            // Génération d'un numéro de dossier unique
            $dossier->setNumeroDossier('DM-' . strtoupper($this->getFaker()->unique()->bothify('####??')));

            $manager->persist($dossier);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            PatientFixtures::class,
        ];
    }
}