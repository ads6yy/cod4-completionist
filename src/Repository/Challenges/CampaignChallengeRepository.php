<?php

namespace App\Repository\Challenges;

use App\Constantes\Challenge\Campaign\CampaignDifficulty;
use App\Entity\Challenge;
use App\Entity\Challenges\CampaignChallenge;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
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

    public function findByDifficultyOrdered(User $user = NULL): array
    {
        $userCompletedChallenges = $user instanceof User ? $user->getCompletedChallenges() : new ArrayCollection();

        $campaignMissions = [];
        $allCampaignMissions = $this->findAll();

        $campaignMissionsByDifficulty = [];
        foreach ($allCampaignMissions as $campaignMission) {
            $campaignDifficulty = $campaignMission->getDifficulty()->value;
            $campaignMissionName = $campaignMission->getCampaignMission()->getName();

            $checkedChallenge = $userCompletedChallenges->exists(function ($key, Challenge $challenge) use ($campaignMission) {
                return $campaignMission->getId() === $challenge->getId();
            });

            if (!isset($campaignMissionsByDifficulty[$campaignDifficulty]['checked'])) {
                $checkedDifficulty = TRUE;
            } else {
                $checkedDifficulty = $campaignMissionsByDifficulty[$campaignDifficulty]['checked'];
                if (!$checkedChallenge) {
                    $checkedDifficulty = FALSE;
                }
            }

            $campaignMissionsByDifficulty[$campaignDifficulty]['checked'] = $checkedDifficulty;

            $campaignMissionsByDifficulty[$campaignDifficulty]['campaign_missions'][$campaignMissionName]['entity'] = $campaignMission;
            $campaignMissionsByDifficulty[$campaignDifficulty]['campaign_missions'][$campaignMissionName]['checked'] = $checkedChallenge;
        }

        foreach (CampaignDifficulty::difficultyOrder() as $difficulty) {
            if (isset($campaignMissionsByDifficulty[$difficulty])) {
                $campaignMissions[$difficulty] = $campaignMissionsByDifficulty[$difficulty];
            }
        }

        return $campaignMissions;
    }
}
