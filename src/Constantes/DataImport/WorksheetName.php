<?php

namespace App\Constantes\DataImport;

enum WorksheetName: string
{
    case WEAPON = 'Weapon';
    case ATTACHMENT = 'Attachment';
    case PERK = 'Perk';
    case LETHAL = 'Lethal';
    case TACTICAL = 'Tactical';
    case STREAK = 'Streak';
    case MAP = 'Map';
    case CAMPAIGN_MISSION = 'Campaign Mission';
    case CAMOUFLAGE_CHALLENGE = 'CamouflageChallenge';
    case CAMPAIGN_CHALLENGE = 'CampaignChallenge';
    case MULTIPLAYER_CHALLENGE = 'MultiplayerChallenge';

    public static function getEntityTypeSheet(string $worksheetName): ?EntityTypeName
    {
        switch (self::tryFrom($worksheetName)) {
            case self::WEAPON:
            case self::ATTACHMENT:
            case self::PERK:
            case self::LETHAL:
            case self::TACTICAL:
            case self::STREAK:
            case self::MAP:
            case self::CAMPAIGN_MISSION:
                return EntityTypeName::WIKI;
            case self::CAMOUFLAGE_CHALLENGE:
            case self::CAMPAIGN_CHALLENGE:
            case self::MULTIPLAYER_CHALLENGE:
                return EntityTypeName::CHALLENGE;
            default:
                return NULL;
        }
    }
}