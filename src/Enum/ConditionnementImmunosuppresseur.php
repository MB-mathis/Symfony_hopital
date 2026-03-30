<?php

namespace App\Enum;

enum ConditionnementImmunosuppresseur: string
{
    case ADVAGRAF = 'Advagraf';
    case PROGRAF = 'Prograf';
    case NEORAL = 'Neoral';
    case RAPAMUNE = 'Rapamune';
    case CERTICAN = 'Certican';
    case CELLCEPT = 'Cellcept';
    case MYFORTIC = 'Myfortic';
    case IMUREL = 'Imurel';
    case METHYLPREDNISOLONE = 'Methylprednisolone';
    case MABTHERA = 'Mabthera';
    case IG_IV = 'Ig IV';
    case SOLIRIS = 'Soliris';
    case THYMOGLOBULINES = 'Thymoglobulines';
    case SIMUELECT = 'Simulect';
    case PLASMAPHERESE = 'Plasmaphérese';
    case IMMUNO_ABSORPTION = 'Immuno absorption';

    public function getLabel(): string
    {
        return match($this) {
            self::ADVAGRAF => 'Advagraf',
            self::PROGRAF => 'Prograf',
            self::NEORAL => 'Neoral',
            self::RAPAMUNE => 'Rapamune',
            self::CERTICAN => 'Certican',
            self::CELLCEPT => 'Cellcept',
            self::MYFORTIC => 'Myfortic',
            self::IMUREL => 'Imurel',
            self::METHYLPREDNISOLONE => 'Methylprednisolone',
            self::MABTHERA => 'Mabthera',
            self::IG_IV => 'Ig IV',
            self::SOLIRIS => 'Soliris',
            self::THYMOGLOBULINES => 'Thymoglobulines',
            self::SIMUELECT => 'Simulect',
            self::PLASMAPHERESE => 'Plasmaphérese',
            self::IMMUNO_ABSORPTION => 'Immuno absorption',
        };
    }
}