<?php

namespace App\Enum;

enum StatutVirologiqueDR: string
{
    case D_NEG_R_NEG = 'D-/R-';
    case D_NEG_R_POS = 'D-/R+';
    case D_POS_R_NEG = 'D+/R-';
    case D_POS_R_POS = 'D+/R+';

    public function getLabel(): string
    {
        return match($this) {
            self::D_NEG_R_NEG => 'D-/R-',
            self::D_NEG_R_POS => 'D-/R+',
            self::D_POS_R_NEG => 'D+/R-',
            self::D_POS_R_POS => 'D+/R+',
        };
    }
}