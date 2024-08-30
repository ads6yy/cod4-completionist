<?php

namespace App\Constantes\DataImport\EntityHeader;

enum WeaponFieldHeader: string
{
    case NAME = 'name';
    case TYPE = 'type';
    case CATEGORY = 'category';
    case UNLOCK_LEVEL = 'unlock_level';
}