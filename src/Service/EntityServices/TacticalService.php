<?php

namespace App\Service\EntityServices;

use App\Constantes\DataImport\EntityHeader\TacticalFieldHeader;
use App\Entity\Tactical;

class TacticalService implements EntityServiceInterface
{
    public function __construct()
    {
    }

    public function setData($entity, array $data): void
    {
        if ($entity instanceof Tactical) {
            if (isset($data[TacticalFieldHeader::NAME->value])) {
                $entity->setName($data[TacticalFieldHeader::NAME->value]);
            }
            if (isset($data[TacticalFieldHeader::UNLOCK_LEVEL->value])) {
                $entity->setUnlockLevel(intval($data[TacticalFieldHeader::UNLOCK_LEVEL->value]));
            }
        }
    }
}