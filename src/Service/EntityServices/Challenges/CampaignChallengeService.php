<?php

namespace App\Service\EntityServices\Challenges;

use App\Constantes\Challenge\Campaign\CampaignDifficulty;
use App\Constantes\Challenge\ChallengeGamemode;
use App\Constantes\DataImport\EntityHeader\Challenges\CampaignFieldHeader;
use App\Entity\CampaignMission;
use App\Entity\Challenges\CampaignChallenge;
use App\Repository\CampaignMissionRepository;
use App\Service\EntityServices\EntityServiceInterface;

class CampaignChallengeService implements EntityServiceInterface
{
    public function __construct(
        private readonly CampaignMissionRepository $campaignMissionRepository,
    )
    {
    }

    public function setData($entity, array $data): void
    {
        if ($entity instanceof CampaignChallenge) {
            if (isset($data[CampaignFieldHeader::NAME->value])) {
                $entity->setName($data[CampaignFieldHeader::NAME->value]);
            }
            if (isset($data[CampaignFieldHeader::GAMEMODE->value])
                && ChallengeGamemode::tryFrom($data[CampaignFieldHeader::GAMEMODE->value])) {
                $entity->setGamemode(ChallengeGamemode::tryFrom($data[CampaignFieldHeader::GAMEMODE->value]));
            }
            if (isset($data[CampaignFieldHeader::DIFFICULTY->value])
                && CampaignDifficulty::tryFrom($data[CampaignFieldHeader::DIFFICULTY->value])) {
                $entity->setDifficulty(CampaignDifficulty::tryFrom($data[CampaignFieldHeader::DIFFICULTY->value]));
            }
            if (isset($data[CampaignFieldHeader::CAMPAIGN_MISSION->value])) {
                $campaignMission = $this->campaignMissionRepository->findOneBy([
                    'name' => $data[CampaignFieldHeader::CAMPAIGN_MISSION->value],
                ]);
                if ($campaignMission instanceof CampaignMission) {
                    $entity->setCampaignMission($campaignMission);
                }
            }
        }
    }
}