<?php

namespace App\Constantes\Challenge;

enum ChallengeGamemode: string
{
    case CAMPAIGN = 'campaign';
    case MULTIPLAYER = 'multiplayer';
    case STEAM = 'steam';
}