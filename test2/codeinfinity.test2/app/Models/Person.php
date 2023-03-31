<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;

define('UPPERCASE','ABCDEFGHIJKLMNOPQRSTUVWXYZ');

class Person extends Model
{
    protected $connection = 'sqlite';

    protected $table = 'people';

    protected $fillable = [
        'csvKey',
        'firstName',
        'lastName',
        'initials',
        'age',
        'dob'
    ];

    private $today;

    use HasFactory;

    public function __construct($csvKey, $firstName, $lastName)
    {
        parent::__construct();
        $this->csvKey = $csvKey;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->today = new DateTime();
        $this->generateInitials();
        $this->generateDOBandAge();
    }

    public function regenerateRandomData()
    {
        $this->generateInitials();
        $this->generateDOBandAge();
    }

    public function getHash()
    {
        $hashingString = $this->firstName.$this->lastName.date_format($this->dob,"Ymd");
        return hash('sha256', $hashingString);
    }



    private function generateInitials()
    {
        $noOfInitials = mt_rand(0,2);
        $initials = $this->firstName[0];
        for ($i = 0; $i < $noOfInitials; ++$i)
        {
            $random_index = mt_rand(0, 26 - 1);
            $initials .= $random_letter = UPPERCASE[$random_index];
        }
        $this->initials = $initials;
    }

    private function generateDOBandAge()
    {
        $years = mt_rand(0,100);
        $months = mt_rand(0,12);
        $days = mt_rand(0,31);

        $date = new DateTime(date_format($this->today,"Y-m-d"));
        date_sub($date,date_interval_create_from_date_string($days." days"));
        date_sub($date,date_interval_create_from_date_string($months." months"));
        date_sub($date,date_interval_create_from_date_string($years." years"));
        $this->dob = $date;

        $diff = $this->today->diff($this->dob);
        $this->age = $diff->y;
    }
}
