<?php

namespace App\Constantes\Challenge\Campaign;

enum CampaignDifficulty: string
{
    case RECRUIT = 'Recruit';
    case REGULAR = 'Regular';
    case HARDENED = 'Hardened';
    case VETERAN = 'Veteran';

    public static function difficultyOrder(): array
    {
        return [
            self::RECRUIT->value,
            self::REGULAR->value,
            self::HARDENED->value,
            self::VETERAN->value,
        ];
    }
}