<?php

namespace App\Constantes\DataImport\EntityHeader\Challenges;

enum CamouflageFieldHeader: string
{
    case NAME = 'name';
    case GAMEMODE = 'gamemode';
    case WEAPON = 'weapon';
    case TYPE = 'type';
    case AMOUNT = 'amount';
}