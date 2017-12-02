<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSharableKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sharable_keys', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id');
            $table->string('recipient_name');
            $table->string('recipient_mail');
            $table->string('private_key');
            $table->string('delete_on');
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
        Schema::dropIfExists('sharable_keys');
    }
}
