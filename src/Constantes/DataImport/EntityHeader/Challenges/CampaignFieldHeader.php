<?php

namespace App\Constantes\DataImport\EntityHeader\Challenges;

enum CampaignFieldHeader: string
{
    case NAME = 'name';
    case GAMEMODE = 'gamemode';
    case DIFFICULTY = 'difficulty';
    case CAMPAIGN_MISSION = 'campaign_mission';
}