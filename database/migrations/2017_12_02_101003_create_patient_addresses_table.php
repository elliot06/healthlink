<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id');
            $table->string('perma_address');
            $table->string('perma_city');
            $table->string('perma_province');
            $table->string('perma_region');
            $table->string('perma_postal');
            $table->string('pres_address');
            $table->string('pres_city');
            $table->string('pres_province');
            $table->string('pres_region');
            $table->string('pres_postal');
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
        Schema::dropIfExists('patient_addresses');
    }
}
