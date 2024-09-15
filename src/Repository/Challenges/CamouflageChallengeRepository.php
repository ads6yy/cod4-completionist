<?php

namespace App\Repository\Challenges;

use App\Constantes\Challenge\Camouflage\CamouflageType;
use App\Entity\Challenge;
use App\Entity\Challenges\CamouflageChallenge;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CamouflageChallenge>
 */
class CamouflageChallengeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CamouflageChallenge::class);
    }

    public function findByWeapon(User $user = NULL): array
    {
        $userCompletedChallenges = $user instanceof User ? $user->getCompletedChallenges() : new ArrayCollection();

        $camouflages = [];
        $allCamouflages = $this->findAll();

        foreach ($allCamouflages as $camouflage) {
            $camouflageWeapon = $camouflage->getWeapon();
            $camouflageWeaponCategory = $camouflageWeapon->getCategory()->value;
            $camouflageWeaponName = $camouflageWeapon->getName();

            if ($camouflage->getType() === CamouflageType::FULL_WEAPON_CATEGORY) {
                $camouflages[$camouflageWeaponCategory]['goldWeapon'] = $camouflageWeaponName;
                $camouflages[$camouflageWeaponCategory]['goldWeaponChallengeId'] = $camouflage->getId();
                $camouflages[$camouflageWeaponCategory]['checked'] = $userCompletedChallenges->exists(function ($key, Challenge $challenge) use ($camouflage) {
                    return $camouflage->getId() === $challenge->getId();
                });;
            } else {
                $checkedCamouflage = !($camouflage->getType() !== CamouflageType::DEFAULT) || $userCompletedChallenges->exists(function ($key, Challenge $challenge) use ($camouflage) {
                        return $camouflage->getId() === $challenge->getId();
                    });

                if (!isset($camouflages[$camouflageWeaponCategory]['weapons'][$camouflageWeaponName]['checked'])) {
                    $checkedWeapon = TRUE;
                } else {
                    $checkedWeapon = $camouflages[$camouflageWeaponCategory]['weapons'][$camouflageWeaponName]['checked'];
                    if (!$checkedCamouflage) {
                        $checkedWeapon = FALSE;
                    }
                }
                $camouflages[$camouflageWeaponCategory]['weapons'][$camouflageWeaponName]['checked'] = $checkedWeapon;

                $camouflages[$camouflageWeaponCategory]['weapons'][$camouflageWeaponName]['camouflages'][$camouflage->getName()]['entity'] = $camouflage;
                $camouflages[$camouflageWeaponCategory]['weapons'][$camouflageWeaponName]['camouflages'][$camouflage->getName()]['checked'] = $checkedCamouflage;
            }
        }

        return $camouflages;
    }
}
