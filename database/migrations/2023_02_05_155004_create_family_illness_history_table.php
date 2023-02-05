<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamilyIllnessHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_illness_history', function (Blueprint $table) {
            $table->id('fih_id');
            $table->string('fih_diabetes');
            $table->string('fih_heart_disease');
            $table->string('fih_mental');
            $table->string('fih_cancer');
            $table->string('fih_hypertension');
            $table->string('fih_kidney_disease');
            $table->string('fih_epilepsy');
            $table->string('fih_others')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('family_illness_history');
    }
}
