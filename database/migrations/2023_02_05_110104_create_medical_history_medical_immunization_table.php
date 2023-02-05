<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalHistoryMedicalImmunizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_history_medical_immunization', function (Blueprint $table) {
            $table->id('mhmi_id');
            $table->boolean('mhmi_bcg');
            $table->boolean('mhmi_mmr');
            $table->boolean('mhmi_hepa_a');
            $table->boolean('mhmi_typhoid');
            $table->boolean('mhmi_varicella');
            $table->integer('mhmi_hepa_b_doses')->nullable();
            $table->integer('mhmi_dpt_doses')->nullable();
            $table->integer('mhmi_opv_doses')->nullable();
            $table->integer('mhmi_hib_doses')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_history_medical_immunization');
    }
}
