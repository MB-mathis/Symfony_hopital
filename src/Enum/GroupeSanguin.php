<?php

namespace App\Enum;

enum GroupeSanguin: string {
    case A = 'A';
    case B = 'B';
    case AB = 'AB';
    case O = 'O';
    case A_POS = 'A+';
    case A_NEG = 'A-';
    case B_POS = 'B+';
    case B_NEG = 'B-';
    case AB_POS = 'AB+';
    case AB_NEG = 'AB-';
    case O_POS = 'O+';
    case O_NEG = 'O-';

    public function getLabel(): string {
        return match($this) {
            self::A => 'A',
            self::B => 'B',
            self::AB => 'AB',
            self::O => 'O',
            self::A_POS => 'A+',
            self::A_NEG => 'A-',
            self::B_POS => 'B+',
            self::B_NEG => 'B-',
            self::AB_POS => 'AB+',
            self::AB_NEG => 'AB-',
            self::O_POS => 'O+',
            self::O_NEG => 'O-',
        };
    }
}
