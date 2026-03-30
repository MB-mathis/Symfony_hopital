<?php

namespace App\Enum;

enum RisqueImmunologique: string
{
    case NON_IMMUNISE = 'Non immunisé';
    case IMMUNISE_SANS_DSA = 'Immunisé sans DSA';
    case IMMUNISE_DSA = 'Immunisé DSA';
    case ABO_INCOMPATIBLE = 'ABO incompatible';

    public function getLabel(): string
    {
        return match($this) {
            self::NON_IMMUNISE => 'Non immunisé',
            self::IMMUNISE_SANS_DSA => 'Immunisé sans DSA',
            self::IMMUNISE_DSA => 'Immunisé DSA',
            self::ABO_INCOMPATIBLE => 'ABO incompatible',
        };
    }

    public function getColor(): string
    {
        // Correspond à la demande métier (vert, orange, rouge)
        return match($this) {
            self::NON_IMMUNISE => 'green',
            self::IMMUNISE_SANS_DSA => 'orange',
            self::IMMUNISE_DSA, 
            self::ABO_INCOMPATIBLE => 'red',
        };
    }
}