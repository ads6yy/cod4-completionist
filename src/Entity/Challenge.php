<?php

namespace App\Entity;

use App\Constantes\Challenge\ChallengeGamemode;
use App\Repository\ChallengeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorMap(['camouflage' => Camouflage::class])]
#[ORM\Entity(repositoryClass: ChallengeRepository::class)]
class Challenge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(enumType: ChallengeGamemode::class)]
    private ?ChallengeGamemode $gamemode = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getGamemode(): ?ChallengeGamemode
    {
        return $this->gamemode;
    }

    public function setGamemode(ChallengeGamemode $gamemode): static
    {
        $this->gamemode = $gamemode;

        return $this;
    }
}
