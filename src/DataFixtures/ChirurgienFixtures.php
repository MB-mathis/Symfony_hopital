<?php

namespace App\DataFixtures;

use App\Entity\Chirurgien;
use Doctrine\Persistence\ObjectManager;

class ChirurgienFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Générer par exemple 10 chirurgiens
        for ($i = 1; $i <= 10; $i++) {
            $chirurgien = new Chirurgien();
            $chirurgien->setNom($this->getFaker()->lastName());
            $chirurgien->setPrenom($this->getFaker()->firstName());

            $manager->persist($chirurgien);

            // Référence pour les autres fixtures (Greffe)
            $this->addReference('chirurgien_' . $i, $chirurgien);
        }

        $manager->flush();
    }
}