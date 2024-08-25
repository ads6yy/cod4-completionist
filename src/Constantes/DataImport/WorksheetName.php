<?php

namespace App\Constantes\DataImport;

enum WorksheetName: string
{
    case WEAPON = 'Weapon';
    case ATTACHMENT = 'Attachment';
    case PERK = 'Perk';
    case LETHAL = 'Lethal';
    case TACTICAL = 'Tactical';
    case STREAK = 'streak';
    case MAP = 'Map';
    case CAMPAIGN_MISSION = 'Campaign Mission';
    case CAMOUFLAGE = 'Camouflage';
}