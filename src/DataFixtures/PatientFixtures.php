<?php

namespace App\DataFixtures;

use App\Entity\Patient;
use App\Enum\Sexe;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\User;

class PatientFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Références des utilisateurs déjà créés
        $userMedical = $this->getReference('user_medical', User::class);
        $userNephrologue = $this->getReference('user_nephrologue', User::class);

        for ($i = 0; $i < 20; $i++) {
            $patient = new Patient();

            $patient->setNom($this->getFaker()->lastName())
                    ->setPrenom($this->getFaker()->firstName())
                    ->setDateNaissance($this->getFaker()->dateTimeBetween('-90 years', '-1 year'))
                    ->setSexe($this->getFaker()->randomElement([Sexe::M, Sexe::F, Sexe::Autre]))
                    ->setVille($this->getFaker()->city())
                    ->setCodePostal($this->getFaker()->postcode())
                    ->setTelephone($this->getFaker()->phoneNumber())
                    ->setEmail($this->getFaker()->email());

            $createdBy = $this->getFaker()->boolean(50) ? $userMedical : $userNephrologue;
            $patient->setCreatedBy($createdBy);

            $manager->persist($patient);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}