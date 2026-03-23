<?php

namespace App\DataFixtures;


use App\Enum\GroupeSanguin;
use App\Enum\Sexe;
use App\Model\DonneurTemplate;
use App\Service\DonneurService;
use Doctrine\Persistence\ObjectManager;


class DonneurFixtures extends Fixture
{
    public function __construct(private DonneurService $donneurService) {}

    public function load(ObjectManager $manager): void
    {
        // -------------------
        // 5 donneurs vivants
        // -------------------
        for ($i = 0; $i < 5; $i++) {
            $data = $this->generateCommonData();

            $data['groupeSanguin'] = $this->getFaker()->randomElement(GroupeSanguin::cases());
            $data['sexe'] = $this->getFaker()->randomElement(Sexe::cases());
            $data['dateNaissance'] = \DateTimeImmutable::createFromMutable(
                $this->getFaker()->dateTime('-60 years')
            );
            $data['taille'] = $this->getFaker()->numberBetween(150, 200) / 100;
            $data['poids'] = $this->getFaker()->numberBetween(50, 100);
            $data['numeroCrista'] = 'CR' . $this->getFaker()->unique()->numberBetween(1000, 9999);

            // Données spécifiques vivant
            $data['data'][DonneurTemplate::KEY_VIVANT] = [
                'nom' => $this->getFaker()->lastName(),
                'prenom' => $this->getFaker()->firstName(),
                'lien_parent_recepteur' => $this->getFaker()->randomElement(['frère','soeur','parent','autre']),
                'commentaire_lien_parent' => $this->getFaker()->sentence(),
                'creatinine' => $this->getFaker()->randomFloat(2, 60, 120),
                'clairance_isotopique' => $this->getFaker()->randomFloat(2, 70, 130),
                'proteinurie' => $this->getFaker()->randomFloat(2, 0, 1),
                'voie_abord' => $this->getFaker()->randomElement(['veineuse','artérielle']),
                'robot' => $this->getFaker()->boolean(),
                'commentaire_clairance' => $this->getFaker()->sentence(),
            ];

            $this->donneurService->createDonneurVivant($data);
        }

        // -------------------
        // 5 donneurs décédés
        // -------------------
        for ($i = 0; $i < 5; $i++) {
            $data = $this->generateCommonData();

            $data['groupeSanguin'] = $this->getFaker()->randomElement(GroupeSanguin::cases());
            $data['sexe'] = $this->getFaker()->randomElement(Sexe::cases());
            $data['dateNaissance'] = \DateTimeImmutable::createFromMutable(
                $this->getFaker()->dateTime('-80 years')
            );
            $data['taille'] = $this->getFaker()->numberBetween(150, 200) / 100;
            $data['poids'] = $this->getFaker()->numberBetween(50, 100);
            $data['numeroCrista'] = 'CR' . $this->getFaker()->unique()->numberBetween(1000, 9999);

            // Données spécifiques décédé
            $data['data'][DonneurTemplate::KEY_DECEDE] = [
                'ville_origine' => $this->getFaker()->city(),
                'cause_deces' => $this->getFaker()->randomElement(['cardiaque','accident','maladie']),
                'commentaire_cause_deces' => $this->getFaker()->sentence(),
                'donneur_criteres_etendus' => $this->getFaker()->boolean(),
                'definition_dce' => $this->getFaker()->sentence(),
                'arret_cardiaque' => $this->getFaker()->boolean(),
                'duree_arret_cardiaque' => $this->getFaker()->numberBetween(1, 60),
                'PA_moyenne' => $this->getFaker()->numberBetween(80, 130),
                'amines' => $this->getFaker()->boolean(),
                'transfusion' => $this->getFaker()->boolean(),
                'CGR' => $this->getFaker()->numberBetween(0, 10),
                'CPA' => $this->getFaker()->numberBetween(0, 10),
                'PFC' => $this->getFaker()->numberBetween(0, 10),
                'creatinine_arrivee' => $this->getFaker()->randomFloat(2, 60, 120),
                'creatinine_prelevement' => $this->getFaker()->randomFloat(2, 60, 120),
                'athérome' => [
                    'aorte' => $this->getFaker()->boolean(),
                    'plaques_aorte' => $this->getFaker()->boolean(),
                    'ostium' => $this->getFaker()->boolean(),
                    'plaques_ostium' => $this->getFaker()->boolean(),
                    'artere_renale' => $this->getFaker()->boolean(),
                    'plaques_renale' => $this->getFaker()->boolean(),
                ],
                'uretere' => $this->getFaker()->boolean(),
                'plaie_digestive' => $this->getFaker()->boolean(),
                'liquide_conservation' => $this->getFaker()->boolean(),
                'infection_liquide' => $this->getFaker()->boolean(),
            ];

            $this->donneurService->createDonneurDecede($data);
        }

        $manager->flush();
    }

    private function generateCommonData(): array
    {
        return [
            'data' => [
                'commentaire_patient' => $this->getFaker()->sentence(),
                DonneurTemplate::KEY_GROUPAGE_HLA => [
                    'A' => $this->getFaker()->randomNumber(2),
                    'B' => $this->getFaker()->randomNumber(2),
                    'Cw' => $this->getFaker()->randomNumber(2),
                    'DR' => $this->getFaker()->randomNumber(2),
                    'DQ' => $this->getFaker()->randomNumber(2),
                    'DP' => $this->getFaker()->randomNumber(2),
                ],
                DonneurTemplate::KEY_SEROLOGIE => array_combine(
                    ['CMV','EBV','toxoplasmose','HIV','HTLV','syphilis','HCV','ARNc','AgHBS','AcHBS','AcHBC','DNAB'],
                    array_map(fn() => $this->getFaker()->boolean(), range(1,12))
                ),
                DonneurTemplate::KEY_PRELEVEMENT => [
                    'date_clampage' => \DateTimeImmutable::createFromMutable(
                        $this->getFaker()->dateTimeThisYear()
                    ),
                    'heure_clampage' => $this->getFaker()->time(),
                    'cote_rein' => $this->getFaker()->randomElement(['gauche','droite']),
                    'commentaire_rein' => $this->getFaker()->sentence(),
                    'arteres' => [
                        'principale' => $this->getFaker()->boolean(),
                        'polaire_sup' => $this->getFaker()->boolean(),
                        'polaire_inf' => $this->getFaker()->boolean(),
                    ],
                    'veine' => [
                        'nom' => 'V'.$this->getFaker()->numberBetween(1,5),
                        'commentaire' => $this->getFaker()->sentence(),
                    ],
                    'machine_perf' => $this->getFaker()->boolean(),
                    'liquide_perf' => $this->getFaker()->boolean(),
                    'infection_liquide' => $this->getFaker()->boolean(),
                ],
            ],
        ];
    }
}