<?php

namespace App\Entity;

use App\Constantes\Challenge\ChallengeGamemode;
use App\Entity\Challenges\CamouflageChallenge;
use App\Entity\Challenges\CampaignChallenge;
use App\Entity\Challenges\MultiplayerChallenge;
use App\Repository\ChallengeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorMap(['camouflage' => CamouflageChallenge::class, 'campaign' => CampaignChallenge::class, 'multiplayer' => MultiplayerChallenge::class])]
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

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'completedChallenges')]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addCompletedChallenge($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeCompletedChallenge($this);
        }

        return $this;
    }
}
