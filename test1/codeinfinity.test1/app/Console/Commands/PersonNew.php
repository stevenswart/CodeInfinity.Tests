<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Person;
use MongoDB\Client;

class PersonNew extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:person:new';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a New Person';

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
    public function handle()
    {
        $firstName = $this->ask('Person First Name:');
        $lastName = $this->ask('Person Last Name:');
        $idNumber = $this->ask('Person SA ID Number:');
        $dob = $this->ask('Person Date of Birth:');
        
        $this->info("Person Name: ".$firstName.' '.$lastName);
        $this->info("Person SA ID Number: ".$idNumber);
        $this->info("Person Date of Birth: ".$dob);
        
        if ($this->confirm('Is this information correct?'))
        {
            $this->info("Person Name: ".$firstName." ".$lastName);
            $this->info("Person SA ID Number: ".$idNumber);
            $this->info("Person Date of Birth: ".$dob);
            $person = new Person();
            $person->firstName = $firstName;
            $person->lastName = $lastName;
            $person->idNumber = $idNumber;
            $person->dob = $dob;
            $person->save();
            
            $this->info("Saved.");
            return 0;
        }

        return 1;
    }
}
