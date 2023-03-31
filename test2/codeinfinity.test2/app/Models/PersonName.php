<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonName extends Model
{
    protected $connection = 'sqlite';

    protected $table = 'person_names';
    
    protected $fillable = [
        'firstName'
    ];


    use HasFactory;
}
