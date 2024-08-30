<?php

namespace App\Repository;

use App\Constantes\Challenge\Camouflage\CamouflageType;
use App\Entity\Camouflage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Camouflage>
 */
class CamouflageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Camouflage::class);
    }

    public function findByWeapon(): array
    {
        $camouflages = [];
        $allCamouflages = $this->findAll();

        foreach ($allCamouflages as $camouflage) {
            $camouflageWeapon = $camouflage->getWeapon();
            $camouflageWeaponCategory = $camouflageWeapon->getCategory()->value;
            $camouflageWeaponName = $camouflageWeapon->getName();
            if ($camouflage->getType() === CamouflageType::FULL_WEAPON_CATEGORY) {
                $camouflages[$camouflageWeaponCategory]['goldWeapon'] = $camouflageWeaponName;
            } else {
                $camouflages[$camouflageWeaponCategory]['weapons'][$camouflageWeaponName][$camouflage->getName()] = $camouflage;
            }
        }

        return $camouflages;
    }
}
