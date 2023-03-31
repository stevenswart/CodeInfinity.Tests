<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PersonName;
use App\Models\Person;

define ('NUMBER_OF_NAMES_IN_ARRAY', 20);
define ('CSV_FILENAME', 'output.csv');

class GenerateCsv extends Command
{
    //const CSV_FILENAME = 'output.csv';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:generateCsv {numberOfRecords}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the CSV file';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    private $firstNamesArr = [];
    private $lastNamesArr = [];
    private $firstAndLastNamesArr = [];
    private $csvPopulateArr = [];

    public function __construct()
    {
        parent::__construct();

    }

    private function parseNames()
    {
        $this->firstAndLastNamesArr[] = PersonName::all('firstAndLastName')->toArray();

        foreach ($this->firstAndLastNamesArr as $firstAndLastNames)
        {
            foreach ($firstAndLastNames as $key => $value)
            {
                foreach ($value as $key => $theName)
                {
                    $firstNameStart = 0;
                    $firstNameEnd = 0;
                    $secondNameStart = 0;
                    $secondNameEnd = strlen($theName);
                    $fullStop = strpos($theName, '.', $firstNameStart);
                    if ($fullStop && (($fullStop + 1) == strlen($theName)))
                    {
                       // do nothing
                    }
                    else if ($fullStop)
                    {
                        $firstNameStart = $fullStop + 2;
                    }
                    $firstNameEnd = strpos($theName, ' ', $firstNameStart);
                    if ($firstNameEnd)
                    {
                        $secondNameStart = $firstNameEnd+1;
                        if ($secondNameStart)
                        {
                            $secondNameEnd = strpos($theName, ' ', $secondNameStart+1);
                            if (!$secondNameEnd)
                            {
                                $secondNameEnd = strlen($theName);
                            }
                        }
                    }
                    if (($firstNameEnd > 0 &&  $firstNameEnd < $secondNameStart) &&
                       ($secondNameStart < $secondNameEnd && $secondNameEnd <= strlen($theName)))
                    {
                        $this->firstNamesArr[] = substr($theName, $firstNameStart, $firstNameEnd - $firstNameStart);
                        $this->lastNamesArr[] = substr($theName, $secondNameStart, $secondNameEnd - $secondNameStart);
                    }
                }
            }
        }
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        runHandle($this->argument('numberOfRecords'));

        return 0;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function runHandle($numberOfRecords)
    {
        $this->parseNames();

        for ($i = 0; $i < $numberOfRecords; ++$i)
        {
            $f = mt_rand(0,NUMBER_OF_NAMES_IN_ARRAY-1);
            $l = mt_rand(0,NUMBER_OF_NAMES_IN_ARRAY-1);
            $person = new Person($i, $this->firstNamesArr[$f], $this->lastNamesArr[$l]);
            $thisHash = $person->getHash();
            while (array_key_exists($thisHash,$this->csvPopulateArr))
            {
                $person->regenerateRandomData();
                $thisHash = $person->getHash();
            }

            $this->csvPopulateArr[$thisHash] = $person;
        }

        if (file_exists(env('CSV_FILEPATH').sprintf("%s",CSV_FILENAME)))
        {
            unlink(env('CSV_FILEPATH').sprintf("%s",CSV_FILENAME));
        }
        /*if ( !file_exists(env('CSV_FILEPATH')) || !is_dir(env('CSV_FILEPATH')) )
        {
            mkdir(env('CSV_FILEPATH'));
        }*/

        $csvFile = fopen(env('CSV_FILEPATH').sprintf("%s",CSV_FILENAME), "w");
        $header= ["ID","FirstName","LastName","Initials","Age","DateOfBirth"];
        fputcsv($csvFile, $header, ",", '"', "\\");

        $counter = 0;
        foreach ($this->csvPopulateArr as $key => $person)
        {
            ++$counter;
            $row= [$counter,$person->firstName,$person->lastName,$person->initials,$person->age,date_format($person->dob, 'd/m/Y')];
            fputcsv($csvFile, $row, ",", '"', "\\");
        }

        fclose($csvFile);

        return 0;
    }
}
