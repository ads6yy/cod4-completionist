<?php

namespace App\Constantes\DataImport\EntityHeader\Challenges;

enum MultiplayerFieldHeader: string
{
    case NAME = 'name';
    case GAMEMODE = 'gamemode';
    case CATEGORY = 'category';
    case TASK = 'task';
    case XP_REWARD = 'xp_reward';
    case UNLOCK_LEVEL = 'unlock_level';
}