<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_families', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('contact');
            $table->string('citizenship');
            $table->string('email');
            $table->string('occupation');
            $table->string('relationship');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_families');
    }
}
