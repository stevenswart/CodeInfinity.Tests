<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

Schema::table('people', function (Blueprint $table) {
    $table->string('idNumber',13)->unique();
    $table->string('dob',10);
});

class Person extends Eloquent
{

    protected $connection = 'mongodb';

    protected $table = 'people';

    protected $fillable = [
        'firstName',
        'lastName',
        'idNumber',
        'dob'
    ];

   // use HasFactory;
}
