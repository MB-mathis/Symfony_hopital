<?php

enum TypeGreffe: string
{
    case Rein = 'Rein';
    case ReinDonneurVivant = 'Rein donneur vivant';
    case ReinPancreas = 'Rein-pancréas';
    case Reinfoie = 'Reinfoie';
    case ReinCoeur = 'Rein-cœur';
    case Autre = 'Autre';

    public function getLabel(): string
    {
        return match($this) {
            self::Rein => 'Rein',
            self::ReinDonneurVivant => 'Rein - donneur vivant',
            self::ReinPancreas => 'Rein-pancréas',
            self::Reinfoie => 'Rein et foie',
            self::ReinCoeur => 'Rein et cœur',
            self::Autre => 'Autre',
        };
    }
}