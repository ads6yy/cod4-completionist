<?php

namespace App\Entity\Challenges;

use App\Constantes\Challenge\Campaign\CampaignDifficulty;
use App\Entity\CampaignMission;
use App\Entity\Challenge;
use App\Repository\Challenges\CampaignChallengeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampaignChallengeRepository::class)]
class CampaignChallenge extends Challenge
{
    #[ORM\Column(enumType: CampaignDifficulty::class)]
    private ?CampaignDifficulty $difficulty = null;

    #[ORM\ManyToOne(inversedBy: 'campaigns')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CampaignMission $campaign_mission = null;

    public function getDifficulty(): ?CampaignDifficulty
    {
        return $this->difficulty;
    }

    public function setDifficulty(CampaignDifficulty $difficulty): static
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getCampaignMission(): ?CampaignMission
    {
        return $this->campaign_mission;
    }

    public function setCampaignMission(?CampaignMission $campaign_mission): static
    {
        $this->campaign_mission = $campaign_mission;

        return $this;
    }
}
