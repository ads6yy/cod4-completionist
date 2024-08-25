<?php

namespace App\Command;

use App\Service\XlsxService;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReader;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(
    name: 'data:import',
    description: 'Import Cod4 game data.',
)]
class DataImportCommand extends Command
{
    const string XLSX_FILEPATH = 'assets/xlsx/Cod4.xlsx';

    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly XlsxService $xlsxService,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {}

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Load xlsx spreadsheet.
        /** @var Xlsx $reader */
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $reader->setIgnoreRowsWithNoCells(true);
        $reader->setReadDataOnly(true);
        $reader->setReadEmptyCells(false);
        $spreadsheet = $reader->load(self::XLSX_FILEPATH);

        // Weapon sheets.
        $class = 'Weapon';
        $entitiesSheetData = $this->xlsxService->sheetToArrayByName($class, $spreadsheet);
        $entitiesDatas = $this->xlsxService->formatDataByHeader($entitiesSheetData);

        $className = "App\Entity\\$class";
        $entitiesRepository = $this->em->getRepository($className);
        $entitiesService = $this->xlsxService->getService($class);

        $errors = [];
        $addedEntities = [];
        $updatedEntities = [];
        foreach ($entitiesDatas as $entityName => $entityData) {
            $existingEntity = $entitiesRepository->findOneBy([
                'name' => $entityName,
            ]);

            if ($existingEntity) {
                $entitiesService->setData($existingEntity, $entityData);
            } else {
                $entity = new $className();
                $entitiesService->setData($entity, $entityData);
            }
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
