<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalHistoryPubertalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_history_pubertal', function (Blueprint $table) {
            $table->id('mhp_id');
            $table->integer('mhp_male_age_on_set')->nullable();
            $table->integer('mhp_female_menarche')->nullable();
            $table->date('mhp_female_lmp')->nullable();
            $table->boolean('mhp_female_dysmenorhea')->nullable();
            $table->string('mhp_female_dysmenorhea_medicine')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_history_pubertal');
    }
}
