<?php

namespace App\Model;

class DonneurTemplate
{
    public const KEY_VIVANT       = 'vivant';
    public const KEY_DECEDE       = 'decede';
    public const KEY_SEROLOGIE    = 'serologie';
    public const KEY_GROUPAGE_HLA = 'groupage_hla';
    public const KEY_PRELEVEMENT  = 'prelevement';

    // IMC, DFG, Clairance calculée = colonnes SQL, pas dans JSON
    public static function getDefaultData(): array
    {
        return [
            // -------------------
            // Commun
            // -------------------
            'commentaire_patient' => null,

            self::KEY_GROUPAGE_HLA => [
                'A'  => null,
                'B'  => null,
                'Cw' => null,
                'DR' => null,
                'DQ' => null,
                'DP' => null,
            ],

            self::KEY_SEROLOGIE => [
                'CMV'          => null,
                'EBV'          => null,
                'toxoplasmose' => null,
                'HIV'          => null,
                'HTLV'         => null,
                'syphilis'     => null,
                'HCV'          => null,
                'ARNc'         => null,
                'AgHBS'        => null,
                'AcHBS'        => null,
                'AcHBC'        => null,
                'DNAB'         => null,
            ],

            self::KEY_PRELEVEMENT => [
                'date_clampage' => null,
                'heure_clampage' => null,
                'cote_rein' => null,
                'commentaire_rein' => null,

                'arteres' => [
                    'principale'  => null,
                    'polaire_sup' => null,
                    'polaire_inf' => null,
                ],

                'veine' => [
                    'nom' => null,
                    'commentaire' => null,
                ],

                'machine_perf' => null,
                'liquide_perf' => null,
                'infection_liquide' => null,
            ],
            // -------------------
            // Vivant
            // -------------------
            self::KEY_VIVANT => [
                'nom' => null,
                'prenom' => null,
                'lien_parent_recepteur' => null,
                'commentaire_lien_parent'=> null,
                'creatinine' => null,
                'clairance_isotopique' => null,
                'proteinurie' => null,
                'voie_abord' => null,
                'robot' => null,
                'commentaire_clairance' => null,
            ],

            // -------------------
            // Décédé
            // -------------------
            self::KEY_DECEDE => [
                'ville_origine' => null,
                'cause_deces' => null,
                'commentaire_cause_deces' => null,
                'donneur_criteres_etendus'=> null,
                'definition_dce' => null,
                'arret_cardiaque' => null,
                'duree_arret_cardiaque' => null,
                'PA_moyenne' => null,
                'amines' => null,
                'transfusion' => null,
                'CGR' => null,
                'CPA' => null,
                'PFC' => null,
                'creatinine_arrivee' => null,
                'creatinine_prelevement' => null,
                'athérome' => [
                    'aorte' => null,
                    'plaques_aorte' => null,
                    'ostium' => null,
                    'plaques_ostium' => null,
                    'artere_renale' => null,
                    'plaques_renale' => null,
                ],
                'uretere' => null,
                'plaie_digestive' => null,
                'liquide_conservation' => null,
                'infection_liquide' => null,
            ],
        ];
    }
}