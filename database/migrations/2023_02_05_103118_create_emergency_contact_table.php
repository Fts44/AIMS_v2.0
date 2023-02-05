<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmergencyContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergency_contact', function (Blueprint $table) {
            $table->id('ec_id');
            $table->string('ec_firstname');
            $table->string('ec_middlename')->nullable();
            $table->string('ec_lastname');
            $table->string('ec_suffixname')->nullable();
            $table->string('ec_relationtopatient');
            $table->string('ec_landline')->nullable();
            $table->string('ec_contact');
            $table->integer('biz_add_id')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emergency_contact');
    }
}
