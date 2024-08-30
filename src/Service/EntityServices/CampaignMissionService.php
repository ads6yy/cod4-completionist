<?php

namespace App\Service\EntityServices;

use App\Constantes\DataImport\EntityHeader\CampaignMissionFieldHeader;
use App\Entity\CampaignMission;
use App\Entity\Map;
use App\Repository\MapRepository;

class CampaignMissionService implements EntityServiceInterface
{
    public function __construct(
        private readonly MapRepository $mapRepository,
    )
    {
    }

    public function setData($entity, array $data): void
    {
        if ($entity instanceof CampaignMission) {
            if (isset($data[CampaignMissionFieldHeader::NAME->value])) {
                $entity->setName($data[CampaignMissionFieldHeader::NAME->value]);
            }
            if (isset($data[CampaignMissionFieldHeader::RELATED_MAPS->value])) {
                $mapNames = explode(',', $data[CampaignMissionFieldHeader::RELATED_MAPS->value]);
                foreach ($mapNames as $mapName) {
                    $mapName = str_replace(' ', '', $mapName);
                    $mapEntity = $this->mapRepository->findOneBy([
                        'name' => $mapName,
                    ]);
                    if ($mapEntity instanceof Map) {
                        $entity->addRelatedMap($mapEntity);
                    }
                }
            }
            if (isset($data[CampaignMissionFieldHeader::LOCATION->value])) {
                $entity->setLocation($data[CampaignMissionFieldHeader::LOCATION->value]);
            }
            if (isset($data[CampaignMissionFieldHeader::NUMBER->value])) {
                $entity->setNumber(intval($data[CampaignMissionFieldHeader::NUMBER->value]));
            }
            if (isset($data[CampaignMissionFieldHeader::BONUS_MISSION->value])) {
                $entity->setBonusMission(boolval($data[CampaignMissionFieldHeader::BONUS_MISSION->value]));
            }
        }
    }
}