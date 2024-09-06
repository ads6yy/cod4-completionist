<?php

namespace App\Repository\Challenges;

use App\Constantes\Challenge\Campaign\CampaignDifficulty;
use App\Entity\Challenges\CampaignChallenge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CampaignChallenge>
 */
class CampaignChallengeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CampaignChallenge::class);
    }

    public function findByDifficultyOrdered(): array
    {
        $campaignMissions = [];
        $allCampaignMissions = $this->findAll();

        $campaignMissionsByDifficulty = [];
        foreach ($allCampaignMissions as $campaignMission) {
            $campaignDifficulty = $campaignMission->getDifficulty()->value;
            $campaignMissionName = $campaignMission->getCampaignMission()->getName();
            $campaignMissionsByDifficulty[$campaignDifficulty][$campaignMissionName] = $campaignMission;
        }

        foreach (CampaignDifficulty::difficultyOrder() as $difficulty) {
            if (isset($campaignMissionsByDifficulty[$difficulty])) {
                $campaignMissions[$difficulty] = $campaignMissionsByDifficulty[$difficulty];
            }
        }

        return $campaignMissions;
    }
}
