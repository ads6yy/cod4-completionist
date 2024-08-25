<?php

namespace App\Service;

interface EntityServiceInterface
{
    public function setData($entity, array $data): void;
}