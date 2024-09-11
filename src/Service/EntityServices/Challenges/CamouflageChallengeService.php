<?php

namespace App\Service\EntityServices\Challenges;

use App\Constantes\Challenge\Camouflage\CamouflageType;
use App\Constantes\Challenge\ChallengeGamemode;
use App\Constantes\DataImport\EntityHeader\Challenges\CamouflageFieldHeader;
use App\Entity\Challenges\CamouflageChallenge;
use App\Entity\Weapon;
use App\Repository\WeaponRepository;
use App\Service\EntityServices\EntityServiceInterface;

class CamouflageChallengeService implements EntityServiceInterface
{
    public function __construct(
        private readonly WeaponRepository $weaponRepository,
    )
    {
    }

    public function setData($entity, array $data): void
    {
        if ($entity instanceof CamouflageChallenge) {
            if (isset($data[CamouflageFieldHeader::NAME->value])) {
                $entity->setName($data[CamouflageFieldHeader::NAME->value]);
            }
            if (isset($data[CamouflageFieldHeader::GAMEMODE->value])
                && ChallengeGamemode::tryFrom($data[CamouflageFieldHeader::GAMEMODE->value])) {
                $entity->setGamemode(ChallengeGamemode::tryFrom($data[CamouflageFieldHeader::GAMEMODE->value]));
            }
            if (isset($data[CamouflageFieldHeader::WEAPON->value])) {
                $weaponEntity = $this->weaponRepository->findOneBy([
                    'name' => $data[CamouflageFieldHeader::WEAPON->value],
                ]);
                if ($weaponEntity instanceof Weapon) {
                    $entity->setWeapon($weaponEntity);
                }
            }
            if (isset($data[CamouflageFieldHeader::TYPE->value])
                && CamouflageType::tryFrom($data[CamouflageFieldHeader::TYPE->value])) {
                $entity->setType(CamouflageType::tryFrom($data[CamouflageFieldHeader::TYPE->value]));
            }
            if (isset($data[CamouflageFieldHeader::AMOUNT->value])) {
                $entity->setAmount(intval($data[CamouflageFieldHeader::AMOUNT->value]));
            }
        }
    }
}