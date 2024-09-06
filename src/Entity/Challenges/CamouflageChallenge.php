<?php

namespace App\Entity\Challenges;

use App\Constantes\Challenge\Camouflage\CamouflageType;
use App\Entity\Challenge;
use App\Entity\Weapon;
use App\Repository\Challenges\CamouflageChallengeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CamouflageChallengeRepository::class)]
class CamouflageChallenge extends Challenge
{
    #[ORM\ManyToOne(inversedBy: 'camouflages')]
    private ?Weapon $weapon = null;

    #[ORM\Column(nullable: true)]
    private ?int $amount = null;

    #[ORM\Column(enumType: CamouflageType::class)]
    private ?CamouflageType $type = null;

    public function getWeapon(): ?Weapon
    {
        return $this->weapon;
    }

    public function setWeapon(?Weapon $weapon): static
    {
        $this->weapon = $weapon;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(?int $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getType(): ?CamouflageType
    {
        return $this->type;
    }

    public function setType(CamouflageType $type): static
    {
        $this->type = $type;

        return $this;
    }
}
