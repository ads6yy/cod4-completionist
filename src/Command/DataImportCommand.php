<?php

namespace App\Command;

use App\Constantes\DataImport\EntityTypeName;
use App\Constantes\DataImport\WorksheetName;
use App\Service\XlsxService;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'data:import',
    description: 'Import Cod4 game data.',
)]
class DataImportCommand extends Command
{
    const string XLSX_FILEPATH = 'assets/xlsx/Cod4.xlsx';

    public function __construct(
        private readonly XlsxService     $xlsxService,
        private readonly LoggerInterface $dataImportLogger,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->dataImportLogger->info('[DATA IMPORT] - Start of data import.');

        try {
            // Load xlsx spreadsheet.
            /** @var Xlsx $reader */
            $reader = IOFactory::createReader('Xlsx');
            $reader->setIgnoreRowsWithNoCells(true);
            $reader->setReadDataOnly(true);
            $reader->setReadEmptyCells(false);
            $spreadsheet = $reader->load(self::XLSX_FILEPATH);

            $worksheetNames = $spreadsheet->getSheetNames();
            foreach ($worksheetNames as $worksheetName) {
                switch (WorksheetName::getEntityTypeSheet($worksheetName)) {
                    case EntityTypeName::WIKI:
                        $this->xlsxService->handleWikiDataWorksheet($worksheetName, $spreadsheet);
                        break;
                    case EntityTypeName::CHALLENGE:
                        $this->xlsxService->handleChallengeDataWorksheet($worksheetName, $spreadsheet);
                        break;
                    default:
                        break;
                }
            }
            return Command::SUCCESS;

        } catch (\Exception $exception) {
            $this->dataImportLogger->error(sprintf("[DATA IMPORT] - Error : %s.",
                $exception->getMessage(),
            ));

            return Command::FAILURE;
        }
    }
}
