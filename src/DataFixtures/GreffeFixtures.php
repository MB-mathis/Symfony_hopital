<?php

namespace App\DataFixtures;

use App\Entity\DossierMedical;
use App\Entity\Chirurgien;
use App\Service\GreffeService;
use App\Service\DonneurService;
use TypeGreffe;
use App\Enum\ConditionnementImmunosuppresseur;
use App\Enum\RisqueImmunologique;
use App\Enum\TypeEn;
use App\Enum\StatutVirologiqueToxo;
use App\Enum\CoteRein;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class GreffeFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private DonneurService $donneurService,
        private GreffeService $greffeService
    ) {}

    public function load(ObjectManager $manager) : void
    {

        $dossiers = $manager->getRepository(DossierMedical::class)->findAll();
        $donneurs = $this->donneurService->getAllDonneurs();
        $chirurgiens = $manager->getRepository(Chirurgien::class)->findAll();

        foreach ($dossiers as $dossier) {
            // Vérifie si dossier a déjà une greffe
            $existingGreffes = $this->greffeService->getGreffesByDossierWithFilters($dossier);
            if (!empty($existingGreffes)) {
                continue;
            }

            $nombreGreffes = rand(1, 2);
            for ($rang = 1; $rang <= $nombreGreffes; $rang++) {
                $donneur = $donneurs[array_rand($donneurs)];
                $chirurgien = $chirurgiens[array_rand($chirurgiens)];

                // Idempotence
                $existing = $this->greffeService->getGreffesByDossierWithFilters(
                    $dossier,
                    ['rangGreffe' => $rang, 'donneur' => $donneur]
                );
                if (!empty($existing)) {
                    continue;
                }

                $greffonFonctionnel = $this->getFaker()->boolean(90);

                // Générer les sous-entités avec choix aléatoires mais uniques
                $typeGreffe = $this->getFaker()->randomElement(TypeGreffe::cases());
                $conditionnementImmunosuppresseur = $this->getFaker()->randomElement(ConditionnementImmunosuppresseur::cases());
                $risqueImmunologique = $this->getFaker()->randomElement(RisqueImmunologique::cases());
                $typeEn = $this->getFaker()->randomElement(TypeEn::cases());
                $coteRein = $this->getFaker()->randomElement(CoteRein::cases());
                $toxoStatus = $this->getFaker()->randomElement(StatutVirologiqueToxo::cases());

                $data = [
                    'rangGreffe' => $rang,
                    'dateGreffe' => $this->getFaker()->dateTimeBetween('-2 years', 'now'),
                    'greffonFonctionnel' => $greffonFonctionnel,
                    'dialyse' =>  $this->getFaker()->boolean(50),
                    'typeGreffe' => $typeGreffe,
                    'conditionnement' => [
                        'conditionnementImmunosuppresseur' => $conditionnementImmunosuppresseur,
                        'risqueImmunologique' => $risqueImmunologique,
                        'commentaireConditionnement' => $this->getFaker()->sentence(),
                        'commentaireRisqueImmunologique' => $this->getFaker()->sentence(),
                    ],
                    'prelevement' => [
                        'dateDeclampage' => $this->getFaker()->dateTimeBetween('-2 years', 'now'),
                        'heureDeclampage' => $this->getFaker()->time(),
                        'en' => $typeEn,
                        'cotePrelevement' => $coteRein,
                        'ischemieTotale' => rand(30, 360),
                        'dureeAnastomoses' => rand(20, 120),
                        'sondeJJ' => $this->getFaker()->boolean(),
                        'commentairePrelevement' => $this->getFaker()->sentence(),
                    ],
                    'serologie' => [
                        'cmvStatus' => $this->getFaker()->randomElement(['D-/R-', 'D-/R+', 'D+/R-', 'D+/R+']),
                        'ebvStatus' => $this->getFaker()->randomElement(['D-/R-', 'D-/R+', 'D+/R-', 'D+/R+']),
                        'toxoStatus' => $toxoStatus,
                    ],
                    'commentaireGreffe' => $greffonFonctionnel ? null : $this->getFaker()->sentence(),
                ];

                if (!$greffonFonctionnel) {
                    $data['dateFinFonctionGreffon'] = $this->getFaker()->dateTimeBetween('now', '+2 years');
                    $data['causeFinFonctionGreffon'] = $this->getFaker()->sentence();
                }

                $this->greffeService->createGreffe($dossier, $donneur, $chirurgien, $data);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            DossierMedicalFixtures::class,
            DonneurFixtures::class,
            ChirurgienFixtures::class,
        ];
    }
}