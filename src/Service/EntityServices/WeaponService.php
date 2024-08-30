<?php

namespace App\Service\EntityServices;

use App\Constantes\DataImport\EntityHeader\WeaponFieldHeader;
use App\Constantes\Weapon\WeaponCategory;
use App\Constantes\Weapon\WeaponType;
use App\Entity\Weapon;

class WeaponService implements EntityServiceInterface
{
    public function __construct()
    {
    }

    public function setData($entity, array $data): void
    {
        if ($entity instanceof Weapon) {
            if (isset($data[WeaponFieldHeader::NAME->value])) {
                $entity->setName($data[WeaponFieldHeader::NAME->value]);
            }
            if (isset($data[WeaponFieldHeader::TYPE->value])
                && WeaponType::tryFrom($data[WeaponFieldHeader::TYPE->value])) {
                $entity->setType(WeaponType::tryFrom($data[WeaponFieldHeader::TYPE->value]));
            }
            if (isset($data[WeaponFieldHeader::CATEGORY->value])
                && WeaponCategory::tryFrom($data[WeaponFieldHeader::CATEGORY->value])) {
                $entity->setCategory(WeaponCategory::tryFrom($data[WeaponFieldHeader::CATEGORY->value]));
            }
            if (isset($data[WeaponFieldHeader::UNLOCK_LEVEL->value])) {
                $entity->setUnlockLevel(intval($data[WeaponFieldHeader::UNLOCK_LEVEL->value]));
            }
        }
    }
}