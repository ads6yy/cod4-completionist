<?php

namespace App\Constantes\DataImport\EntityHeader;

enum StreakFieldHeader: string
{
    case NAME = 'name';
    case UNLOCK_LEVEL = 'unlock_level';
    case UNLOCK_NB_KILLS = 'unlock_nb_kills';
}