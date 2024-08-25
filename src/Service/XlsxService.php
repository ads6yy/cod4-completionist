<?php

namespace App\Service;

use PhpOffice\PhpSpreadsheet\Spreadsheet;

class XlsxService
{
    public function __construct(
        private readonly WeaponService $weaponService,
    )
    {
    }

    public function sheetToArrayByName(string $sheetName, Spreadsheet $spreadsheet): array
    {
        $sheet = $spreadsheet->getSheetByName($sheetName);
        $highestRow = $sheet->getHighestDataRow();
        $highestColumn = $sheet->getHighestDataColumn();
        return $sheet->rangeToArray("A1:$highestColumn$highestRow");
    }

    public function formatDataByHeader(array $data): array
    {
        $formattedData = [];

        $dataHeaderTable = $data[0];
        unset($data[0]);

        foreach ($data as $values) {

            $name = $this->getValueByHeaderName($dataHeaderTable, $values, 'name');

            foreach ($values as $key => $content) {
                if (isset($dataHeaderTable[$key])) {
                    $formattedData[$name][$dataHeaderTable[$key]] = $content;
                }
            }
        }

        return $formattedData;
    }

    public function getValueByHeaderName(array $header, array $values, string $headerName): mixed
    {
        $fieldValueKey = array_keys($header, $headerName);
        $fieldValueKey = reset($fieldValueKey);
        return $values[$fieldValueKey];
    }

    public function getService(string $name): EntityServiceInterface {
        return match ($name) {
            'Weapon' => $this->weaponService,
            default => throw new \Exception("$name service not found"),
        };
    }
}