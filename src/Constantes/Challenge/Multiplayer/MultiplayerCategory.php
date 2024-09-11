<?php

namespace App\Constantes\Challenge\Multiplayer;

enum MultiplayerCategory: string
{
    case BOOT_CAMP = 'Boot Camp';
    case OPERATIONS = 'Operations';
    case KILLER = 'Killer';
    case HUMILIATION = 'Humiliation';
    case ELITE = 'Elite';

    public static function categoryOrder(): array
    {
        return [
            self::BOOT_CAMP->value,
            self::OPERATIONS->value,
            self::KILLER->value,
            self::HUMILIATION->value,
            self::ELITE->value,
        ];
    }
}