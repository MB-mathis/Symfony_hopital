<?php

namespace App\Enum;

enum Sexe: string {
    case M = 'M';
    case F = 'F';
    case Autre = 'Autre';

    public function getLabel(): string {
        return match($this) {
            self::M => 'Masculin',
            self::F => 'Féminin',
            self::Autre => 'Autre',
        };
    }
}