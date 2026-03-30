<?php

namespace App\Enum;

enum StatutVirologiqueToxo: string
{
    case R_NEG = 'R-';
    case R_POS = 'R+';

    public function getLabel(): string
    {
        return match($this) {
            self::R_NEG => 'Receveur négatif',
            self::R_POS => 'Receveur positif',
        };
    }
}