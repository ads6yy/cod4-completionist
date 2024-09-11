<?php

namespace App\Service\EntityServices\Challenges;

use App\Constantes\Challenge\ChallengeGamemode;
use App\Constantes\Challenge\Multiplayer\MultiplayerCategory;
use App\Constantes\DataImport\EntityHeader\Challenges\MultiplayerFieldHeader;
use App\Entity\Challenges\MultiplayerChallenge;
use App\Service\EntityServices\EntityServiceInterface;

class MultiplayerChallengeService implements EntityServiceInterface
{
    public function __construct(
    )
    {
    }

    public function setData($entity, array $data): void
    {
        if ($entity instanceof MultiplayerChallenge) {
            if (isset($data[MultiplayerFieldHeader::NAME->value])) {
                $entity->setName($data[MultiplayerFieldHeader::NAME->value]);
            }
            if (isset($data[MultiplayerFieldHeader::GAMEMODE->value])
                && ChallengeGamemode::tryFrom($data[MultiplayerFieldHeader::GAMEMODE->value])) {
                $entity->setGamemode(ChallengeGamemode::tryFrom($data[MultiplayerFieldHeader::GAMEMODE->value]));
            }
            if (isset($data[MultiplayerFieldHeader::CATEGORY->value])
                && MultiplayerCategory::tryFrom($data[MultiplayerFieldHeader::CATEGORY->value])) {
                $entity->setCategory(MultiplayerCategory::tryFrom($data[MultiplayerFieldHeader::CATEGORY->value]));
            }
            if (isset($data[MultiplayerFieldHeader::TASK->value])) {
                $entity->setTask($data[MultiplayerFieldHeader::TASK->value]);
            }
            if (isset($data[MultiplayerFieldHeader::XP_REWARD->value])) {
                $entity->setXpReward($data[MultiplayerFieldHeader::XP_REWARD->value]);
            }
            if (isset($data[MultiplayerFieldHeader::UNLOCK_LEVEL->value])) {
                $entity->setUnlockLevel($data[MultiplayerFieldHeader::UNLOCK_LEVEL->value]);
            }
        }
    }
}