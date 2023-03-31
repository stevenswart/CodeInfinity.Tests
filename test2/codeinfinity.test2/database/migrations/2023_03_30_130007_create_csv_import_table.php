<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCsvImportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csv_import', function (Blueprint $table) {
            $table->integer('csv_key')->unique;
            $table->string('firstName',255);
            $table->string('lastName',255);
            $table->string('initials',3);
            $table->integer('age');
            $table->date('dob');
            $table->unique(['firstName', 'lastName', 'initials', 'dob']);
            $table->unique(['firstName', 'lastName', 'initials', 'dob', 'age']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('csv_import');
    }
}
