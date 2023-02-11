<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccinationDoseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccination_dose_details', function (Blueprint $table) {
            $table->id('vdd_id');
            $table->integer('vdd_dose_number');
            $table->integer('vdd_brand_id');
            $table->date('vdd_date');
            $table->string('vdd_lot_number');
            $table->string('vdd_prov_code');
            $table->string('vdd_mun_code');
            $table->integer('acc_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vaccination_dose_details');
    }
}
