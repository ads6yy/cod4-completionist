<?php

namespace App\Service\EntityServices;

use App\Constantes\DataImport\EntityHeader\PerkFieldHeader;
use App\Constantes\Perk\PerkCategory;
use App\Entity\Perk;

class PerkService implements EntityServiceInterface
{
    public function __construct()
    {
    }

    public function setData($entity, array $data): void
    {
        if ($entity instanceof Perk) {
            if (isset($data[PerkFieldHeader::NAME->value])) {
                $entity->setName($data[PerkFieldHeader::NAME->value]);
            }
            if (isset($data[PerkFieldHeader::CATEGORY->value])
                && PerkCategory::tryFrom($data[PerkFieldHeader::CATEGORY->value])) {
                $entity->setCategory(PerkCategory::tryFrom($data[PerkFieldHeader::CATEGORY->value]));
            }
            if (isset($data[PerkFieldHeader::UNLOCK_LEVEL->value])) {
                $entity->setUnlockLevel(intval($data[PerkFieldHeader::UNLOCK_LEVEL->value]));
            }
        }
    }
}