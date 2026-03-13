<?php

namespace App\Enum;

enum TypeGreffe: string
{
    case Rein = 'Rein';
    case ReinDonneurVivant = 'Rein donneur vivant';
    case ReinPancreas = 'Rein-pancréas';
    case Reinfoie = 'Reinfoie';
    case ReinCoeur = 'Rein-cœur';
    case Autre = 'Autre';
}