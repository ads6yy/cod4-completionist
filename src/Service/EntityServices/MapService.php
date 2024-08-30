<?php

namespace App\Service\EntityServices;

use App\Constantes\DataImport\EntityHeader\MapFieldHeader;
use App\Constantes\Map\MapSize;
use App\Entity\Map;

class MapService implements EntityServiceInterface
{
    public function __construct()
    {
    }

    public function setData($entity, array $data): void
    {
        if ($entity instanceof Map) {
            if (isset($data[MapFieldHeader::NAME->value])) {
                $entity->setName($data[MapFieldHeader::NAME->value]);
            }
            if (isset($data[MapFieldHeader::SIZE->value])
                && MapSize::tryFrom($data[MapFieldHeader::SIZE->value])) {
                $entity->setSize(MapSize::tryFrom($data[MapFieldHeader::SIZE->value]));
            }
            if (isset($data[MapFieldHeader::LOCATION->value])) {
                $entity->setLocation($data[MapFieldHeader::LOCATION->value]);
            }
            if (isset($data[MapFieldHeader::DLC->value])) {
                $entity->setDlc(boolval($data[MapFieldHeader::DLC->value]));
            }
        }
    }
}