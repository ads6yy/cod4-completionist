<?php

namespace App\Service\EntityServices;

use App\Constantes\DataImport\EntityHeader\AttachmentFieldHeader;
use App\Entity\Attachment;

class AttachmentService implements EntityServiceInterface
{
    public function __construct()
    {
    }

    public function setData($entity, array $data): void
    {
        if ($entity instanceof Attachment) {
            if (isset($data[AttachmentFieldHeader::NAME->value])) {
                $entity->setName($data[AttachmentFieldHeader::NAME->value]);
            }
        }
    }
}