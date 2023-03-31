<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsvImport extends Model
{
    protected $connection = 'sqlite';

    protected $table = 'csv_import';

    protected $fillable = [
        'csv_key',
        'firstName',
        'lastName',
        'initials',
        'age',
        'dob'
    ];
    use HasFactory;
}
