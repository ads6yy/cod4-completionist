<?php

namespace App\Service;

use App\Constantes\DataImport\EntityHeader\CamouflageFieldHeader;
use App\Constantes\DataImport\WorksheetName;
use App\Entity\Camouflage;
use App\Entity\Weapon;
use App\Repository\WeaponRepository;
use App\Service\EntityServices\AttachmentService;
use App\Service\EntityServices\CamouflageService;
use App\Service\EntityServices\CampaignMissionService;
use App\Service\EntityServices\EntityServiceInterface;
use App\Service\EntityServices\LethalService;
use App\Service\EntityServices\MapService;
use App\Service\EntityServices\PerkService;
use App\Service\EntityServices\StreakService;
use App\Service\EntityServices\TacticalService;
use App\Service\EntityServices\WeaponService;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class XlsxService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ValidatorInterface     $validator,
        private readonly LoggerInterface        $dataImportLogger,
        private readonly WeaponService          $weaponService,
        private readonly AttachmentService      $attachmentService,
        private readonly PerkService            $perkService,
        private readonly LethalService          $lethalService,
        private readonly TacticalService        $tacticalService,
        private readonly StreakService          $streakService,
        private readonly MapService             $mapService,
        private readonly CampaignMissionService $campaignMissionService,
        private readonly CamouflageService      $camouflageService,
        private readonly WeaponRepository       $weaponRepository,
    )
    {
    }

    public function handleWikiDataWorksheet(string $sheetName, Spreadsheet $spreadsheet): void
    {
        // Wiki data sheet.
        $entitiesSheetData = $this->sheetToArrayByName($sheetName, $spreadsheet);
        $entitiesDatas = $this->formatDataByHeader($entitiesSheetData);

        $className = str_replace(' ', '', $sheetName);
        $entityClass = "App\Entity\\$className";
        $entitiesRepository = $this->em->getRepository($entityClass);
        $entitiesService = $this->getService($sheetName);

        $addedEntities = 0;
        $updatedEntities = 0;
        foreach ($entitiesDatas as $entityName => $entityData) {
            try {
                $this->dataImportLogger->info("[DATA IMPORT] - $sheetName entity $entityName - Start.");

                $existingEntity = $entitiesRepository->findOneBy([
                    'name' => $entityName,
                ]);

                if ($existingEntity) {
                    $this->dataImportLogger->info("[DATA IMPORT] - $sheetName entity $entityName - Update.");

                    $entity = $existingEntity;
                    $entitiesService->setData($entity, $entityData);
                    $updatedEntities++;
                } else {
                    $this->dataImportLogger->info("[DATA IMPORT] - $sheetName entity $entityName - Add.");

                    $entity = new $entityClass();
                    $entitiesService->setData($entity, $entityData);
                    $addedEntities++;
                }

                // Validation ORM.
                $errorsList = $this->validator->validate($entity);
                if ($errorsList->count() > 0) {
                    /** @var ConstraintViolation $error */
                    foreach ($errorsList as $error) {
                        throw new \Exception(sprintf("Validation error - %s.",
                            sprintf('%s - %s',
                                $error->getPropertyPath(),
                                $error->getMessage()
                            )
                        ));
                    }
                } else {
                    $this->em->persist($entity);

                    $this->dataImportLogger->info("[DATA IMPORT] - $sheetName entity $entityName - End.");
                }
            } catch (\Exception $exception) {
                $this->dataImportLogger->info(sprintf("[DATA IMPORT] - $sheetName entity $entityName - Error : %s.",
                    $exception->getMessage(),
                ));
            }
        }

        $this->em->flush();

        $this->dataImportLogger->info(sprintf('[DATA IMPORT] - End of data import - %s entities added, %s entities updated.',
            $addedEntities,
            $updatedEntities,
        ));
    }

    public function handleChallengeDataWorksheet(string $sheetName, Spreadsheet $spreadsheet): void
    {
        // Wiki data sheet.
        $entitiesSheetData = $this->sheetToArrayByName($sheetName, $spreadsheet);
        $entitiesDatas = $this->formatDataByHeader($entitiesSheetData, NULL);

        $className = str_replace(' ', '', $sheetName);
        $entityClass = "App\Entity\\$className";
        $entitiesRepository = $this->em->getRepository($entityClass);
        $entitiesService = $this->getService($sheetName);

        $addedEntities = 0;
        $updatedEntities = 0;
        foreach ($entitiesDatas as $entityName => $entityData) {
            try {
                $this->dataImportLogger->info("[DATA IMPORT] - $sheetName entity $entityName - Start.");

                switch ($entityClass) {
                    case Camouflage::class:
                        $weapon = $this->weaponRepository->findOneBy([
                            'name' => $entityData[CamouflageFieldHeader::WEAPON->value],
                        ]);
                        if (!$weapon instanceof Weapon) {
                            throw new \Exception("Weapon {$entityData[CamouflageFieldHeader::WEAPON->value]} unknown.");
                        }
                        $searchCriteria = [
                            'name' => $entityData[CamouflageFieldHeader::NAME->value],
                            'weapon' => $weapon,
                        ];
                        break;
                    default:
                        $searchCriteria = [
                            'name' => $entityData['name'],
                        ];
                        break;
                }

                $existingEntity = $entitiesRepository->findOneBy($searchCriteria);

                if ($existingEntity) {
                    $this->dataImportLogger->info("[DATA IMPORT] - $sheetName entity $entityName - Update.");

                    $entity = $existingEntity;
                    $entitiesService->setData($entity, $entityData);
                    $updatedEntities++;
                } else {
                    $this->dataImportLogger->info("[DATA IMPORT] - $sheetName entity $entityName - Add.");

                    $entity = new $entityClass();
                    $entitiesService->setData($entity, $entityData);
                    $addedEntities++;
                }

                // Validation ORM.
                $errorsList = $this->validator->validate($entity);
                if ($errorsList->count() > 0) {
                    /** @var ConstraintViolation $error */
                    foreach ($errorsList as $error) {
                        throw new \Exception(sprintf("Validation error - %s.",
                            sprintf('%s - %s',
                                $error->getPropertyPath(),
                                $error->getMessage()
                            )
                        ));
                    }
                } else {
                    $this->em->persist($entity);

                    $this->dataImportLogger->info("[DATA IMPORT] - $sheetName entity $entityName - End.");
                }
            } catch (\Exception $exception) {
                $this->dataImportLogger->info(sprintf("[DATA IMPORT] - $sheetName entity $entityName - Error : %s.",
                    $exception->getMessage(),
                ));
            }
        }

        $this->em->flush();

        $this->dataImportLogger->info(sprintf('[DATA IMPORT] - End of data import - %s entities added, %s entities updated.',
            $addedEntities,
            $updatedEntities,
        ));
    }

    public function sheetToArrayByName(string $sheetName, Spreadsheet $spreadsheet): array
    {
        $sheet = $spreadsheet->getSheetByName($sheetName);
        $highestRow = $sheet->getHighestDataRow();
        $highestColumn = $sheet->getHighestDataColumn();
        return $sheet->rangeToArray("A1:$highestColumn$highestRow");
    }

    public function formatDataByHeader(array $data, $primaryHeader = 'name'): array
    {
        $formattedData = [];

        $dataHeaderTable = $data[0];
        unset($data[0]);

        foreach ($data as $values) {

            $primaryHeaderValue = $primaryHeader
                ? $this->getValueByHeaderName($dataHeaderTable, $values, $primaryHeader)
                : NULL;

            $rowContent = [];
            foreach ($values as $key => $content) {
                if (isset($dataHeaderTable[$key])) {
                    $rowContent[$dataHeaderTable[$key]] = $content;
                }
            }
            if ($primaryHeaderValue) {
                $formattedData[$primaryHeaderValue] = $rowContent;
            } else {
                $formattedData[] = $rowContent;
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

    public function getService(string $name): EntityServiceInterface
    {
        return match (WorksheetName::tryFrom($name)) {
            WorksheetName::WEAPON => $this->weaponService,
            WorksheetName::ATTACHMENT => $this->attachmentService,
            WorksheetName::PERK => $this->perkService,
            WorksheetName::LETHAL => $this->lethalService,
            WorksheetName::TACTICAL => $this->tacticalService,
            WorksheetName::STREAK => $this->streakService,
            WorksheetName::MAP => $this->mapService,
            WorksheetName::CAMPAIGN_MISSION => $this->campaignMissionService,
            WorksheetName::CAMOUFLAGE => $this->camouflageService,
            default => throw new \Exception("$name service not found"),
        };
    }
}