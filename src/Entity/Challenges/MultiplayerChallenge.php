<?php

namespace App\Entity\Challenges;

use App\Constantes\Challenge\Multiplayer\MultiplayerCategory;
use App\Entity\Challenge;
use App\Repository\Challenges\MultiplayerChallengeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MultiplayerChallengeRepository::class)]
class MultiplayerChallenge extends Challenge
{
    #[ORM\Column]
    private ?int $unlock_level = null;

    #[ORM\Column]
    private ?int $xp_reward = null;

    #[ORM\Column(enumType: MultiplayerCategory::class)]
    private ?MultiplayerCategory $category = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $task = null;

    public function getUnlockLevel(): ?int
    {
        return $this->unlock_level;
    }

    public function setUnlockLevel(int $unlock_level): static
    {
        $this->unlock_level = $unlock_level;

        return $this;
    }

    public function getXpReward(): ?int
    {
        return $this->xp_reward;
    }

    public function setXpReward(int $xp_reward): static
    {
        $this->xp_reward = $xp_reward;

        return $this;
    }

    public function getCategory(): ?MultiplayerCategory
    {
        return $this->category;
    }

    public function setCategory(MultiplayerCategory $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getTask(): ?string
    {
        return $this->task;
    }

    public function setTask(string $task): static
    {
        $this->task = $task;

        return $this;
    }
}
