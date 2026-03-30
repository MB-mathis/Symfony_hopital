<?php

namespace App\Enum;

enum CoteRein: string
{
    case DROIT = 'droit';
    case GAUCHE = 'gauche';

    public function getLabel(): string
    {
        return match($this) {
            self::DROIT => 'Droit',
            self::GAUCHE => 'Gauche',
        };
    }
}