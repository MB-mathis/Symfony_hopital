<?php

namespace App\Enum;

enum TypeEn: string
{
    case EXTRA_PERITONEAL = 'Extra Péritonéal';
    case INTRA_PERITONEAL = 'Intra Péritonéal';

    public function getLabel(): string
    {
        return match($this) {
            self::EXTRA_PERITONEAL => 'Extra Péritonéal',
            self::INTRA_PERITONEAL => 'Intra Péritonéal',
        };
    }
}