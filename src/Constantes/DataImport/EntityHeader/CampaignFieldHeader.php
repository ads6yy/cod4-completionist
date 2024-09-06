<?php

namespace App\Constantes\DataImport\EntityHeader;

enum CampaignFieldHeader: string
{
    case NAME = 'name';
    case GAMEMODE = 'gamemode';
    case DIFFICULTY = 'difficulty';
    case CAMPAIGN_MISSION = 'campaign_mission';
}