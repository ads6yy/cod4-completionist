<?php

namespace App\Constantes\DataImport\EntityHeader;

enum MapFieldHeader: string
{
    case NAME = 'name';
    case SIZE = 'size';
    case LOCATION = 'location';
    case DLC = 'dlc';
}