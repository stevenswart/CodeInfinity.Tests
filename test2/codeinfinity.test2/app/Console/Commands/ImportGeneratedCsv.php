<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CsvImport;

class ImportGeneratedCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:importCsv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command imports the generated CSV into the SQLite database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function importTheGeneratedCsv($fullFilenameWithPath)
    {
        set_time_limit(0);
        if (!file_exists($fullFilenameWithPath))
        {
            $this->info("No generated CSV file found!");
            return 1;
        }

        $csvFile = fopen($fullFilenameWithPath, "r");

        $count = 0;
        $row = fgetcsv($csvFile, null, ",", '"', "\\");
        while (!is_bool($row))
        {
            $import_csv = new CsvImport();
            $row = fgetcsv($csvFile, null, ",", '"', "\\");
            if (!is_bool($row))
            {
                $import_csv->csv_key = $row[0];
                $import_csv->firstName = $row[1];
                $import_csv->lastName = $row[2];
                $import_csv->initials = $row[3];
                $import_csv->age = $row[4];
                $import_csv->dob = $row[5];
                $import_csv->save();
                ++$count;
            }
        }

        fclose($csvFile);

        return $count;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return $this->importTheGeneratedCsv(env('CSV_FILEPATH').sprintf("%s",CSV_FILENAME));
    }
}
