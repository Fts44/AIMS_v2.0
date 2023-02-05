<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {

            $table->id('acc_id');
            $table->string('password');
            $table->string('pfp')->nullable();
            $table->boolean('is_verified')->default(0);
            $table->dateTime('date_created')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('sr_code')->unique()->nullable();
            $table->string('gsuite_email')->unique()->nullable();
            $table->string('prsn_email')->unique()->nullable();
            $table->string('contact')->unique()->nullable();
            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('lastname')->nullable();
            $table->string('suffixname')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('sex')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('religion')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('blood_type')->nullable();

            $table->string('classification')->nullable();
            $table->string('position')->nullable();
            
            $table->string('license_no')->nullable();
            $table->string('signature')->nullable();
            $table->integer('ttl_id')->nullable()->unique();

            $table->integer('home_add_id')->nullable()->unique();
            $table->integer('birth_add_id')->nullable()->unique();
            $table->integer('dorm_add_id')->nullable()->unique();

            $table->integer('fd_id')->nullable()->unique();
            $table->integer('fih_id')->nullable()->unique();

            $table->integer('ec_id')->nullable()->unique();
           
            $table->integer('gl_id')->nullable();
            $table->integer('dept_id')->nullable();
            $table->integer('prog_id')->nullable();
            $table->integer('yl_id')->nullable();

            $table->integer('mhpi_id')->nullable()->unique();
            $table->integer('mha_id')->nullable()->unique();
            $table->integer('mhp_id')->nullable()->unique();
            $table->integer('mhmi_id')->nullable()->unique();
            $table->integer('ad_id')->nullable()->unique();

            $table->integer('vs_id')->nullable()->unique();
            $table->integer('vdd_id')->nullable()->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
