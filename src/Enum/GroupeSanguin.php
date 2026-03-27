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
}
