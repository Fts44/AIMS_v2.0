<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalHistoryPastIllnessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_history_past_illness', function (Blueprint $table) {
            $table->id('mhpi_id');
            $table->string('mhpi_hospitalization_specify')->nullable();
            $table->string('mhpi_operation_specify')->nullable();
            $table->string('mhpi_accident_specify')->nullable();
            $table->string('mhpi_disability_specify')->nullable();
            $table->date('mhpi_asthma_last_attack')->nullable();
            $table->boolean('mhpi_diabetes');
            $table->boolean('mhpi_epilepsy');
            $table->boolean('mhpi_heart_disease');
            $table->boolean('mhpi_hypertension');
            $table->boolean('mhpi_measles');
            $table->boolean('mhpi_mumps');
            $table->boolean('mhpi_thyroid_problem');
            $table->boolean('mhpi_varicella');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_history_past_illness');
    }
}
