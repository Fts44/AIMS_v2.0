<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCovidVaccinationBrandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('covid_vaccination_brand', function (Blueprint $table) {
            $table->id('cvb_id');
            $table->string('cvb_brand');
        });
        
        DB::table('covid_vaccination_brand')->insert([
            ["cvb_id" => 1, "cvb_brand" => "Pfizer-BioNTech"],
            ["cvb_id" => 2, "cvb_brand" => "Oxford-AstraZeneca"],
            ["cvb_id" => 3, "cvb_brand" => "CoronaVac (Sinovac)"],
            ["cvb_id" => 4, "cvb_brand" => "Gamaleya Sputnik V"],
            ["cvb_id" => 5, "cvb_brand" => "Johnson and Johnson's Janssen"],
            ["cvb_id" => 6, "cvb_brand" => "Bharat BioTech"],
            ["cvb_id" => 7, "cvb_brand" => "Moderna"],
            ["cvb_id" => 8, "cvb_brand" => "Sinopharm"],
            ["cvb_id" => 9, "cvb_brand" => "Novavax"],
            ["cvb_id" => 10, "cvb_brand" => "Others"]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('covid_vaccination_brand');
    }
}
