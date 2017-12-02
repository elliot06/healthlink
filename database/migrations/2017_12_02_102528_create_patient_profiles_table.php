<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('home_contact');
            $table->string('cell_contact');
            $table->string('gender');
            $table->string('age');
            $table->string('birthdate');
            $table->string('citizenship');
            $table->integer('height');
            $table->integer('weight');
            $table->integer('bmi');
            $table->string('bmi_category');
            $table->string('blood_type');
            $table->boolean('deceased')->nullable();
            $table->string('death_date')->nullable();
            $table->string('cause_of_death')->nullable();
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
        Schema::dropIfExists('patient_profiles');
    }
}
