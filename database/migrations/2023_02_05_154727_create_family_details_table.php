<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamilyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_details', function (Blueprint $table) {
            $table->id('fd_id');
            $table->string('fd_father_firstname');
            $table->string('fd_father_middlename')->nullable();
            $table->string('fd_father_lastname');
            $table->string('fd_father_suffixname')->nullable();
            $table->string('fd_father_occupation');
            $table->string('fd_mother_firstname');
            $table->string('fd_mother_middlename')->nullable();
            $table->string('fd_mother_lastname');
            $table->string('fd_mother_suffixname')->nullable();
            $table->string('fd_mother_occupation');
            $table->string('fd_marital_status');
            $table->integer('fih_id')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('family_details');
    }
}
