<?php

namespace App\Service\EntityServices;

use App\Constantes\DataImport\EntityHeader\StreakFieldHeader;
use App\Entity\Streak;

class StreakService implements EntityServiceInterface
{
    public function __construct()
    {
    }

    public function setData($entity, array $data): void
    {
        if ($entity instanceof Streak) {
            if (isset($data[StreakFieldHeader::NAME->value])) {
                $entity->setName($data[StreakFieldHeader::NAME->value]);
            }
            if (isset($data[StreakFieldHeader::UNLOCK_LEVEL->value])) {
                $entity->setUnlockLevel(intval($data[StreakFieldHeader::UNLOCK_LEVEL->value]));
            }
            if (isset($data[StreakFieldHeader::UNLOCK_NB_KILLS->value])) {
                $entity->setUnlockNbKills(intval($data[StreakFieldHeader::UNLOCK_NB_KILLS->value]));
            }
        }
    }
}