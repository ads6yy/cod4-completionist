<?php

namespace App\Service\EntityServices;

use App\Constantes\DataImport\EntityHeader\LethalFieldHeader;
use App\Entity\Lethal;

class LethalService implements EntityServiceInterface
{
    public function __construct()
    {
    }

    public function setData($entity, array $data): void
    {
        if ($entity instanceof Lethal) {
            if (isset($data[LethalFieldHeader::NAME->value])) {
                $entity->setName($data[LethalFieldHeader::NAME->value]);
            }
            if (isset($data[LethalFieldHeader::UNLOCK_LEVEL->value])) {
                $entity->setUnlockLevel(intval($data[LethalFieldHeader::UNLOCK_LEVEL->value]));
            }
        }
    }
}