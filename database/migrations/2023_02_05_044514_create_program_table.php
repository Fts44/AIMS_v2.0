<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program', function (Blueprint $table) {
            $table->id('prog_id');
            $table->string('prog_code');
            $table->string('prog_name');
            $table->string('dept_id');
        });

        DB::table('program')->insert([
            [
                'prog_id' => '1',
                'prog_code' => 'BSA',
                'prog_name' =>  'BS Accountancy',
                'dept_id' => '1'
            ],
            [
                'prog_id' => '2',
                'prog_code' => 'BSBA',
                'prog_name' =>  'BS Business Administration',
                'dept_id' => '1'
            ],
            [
                'prog_id' => '3',
                'prog_code' => 'BSHM',
                'prog_name' =>  'BS Hospitality Management',
                'dept_id' => '1'
            ],
            [
                'prog_id' => '4',
                'prog_code' => 'BSTM',
                'prog_name' =>  'BS Tourism Management',
                'dept_id' => '1'
            ],
            [
                'prog_id' => '5',
                'prog_code' => 'BSBio',
                'prog_name' =>  'BS Biology',
                'dept_id' => '2'
            ],
            [
                'prog_id' => '6',
                'prog_code' => 'BSChem',
                'prog_name' =>  'BS Chemistry',
                'dept_id' => '2'
            ],
            [
                'prog_id' => '7',
                'prog_code' => 'BSCriminology',
                'prog_name' =>  'BS Criminology',
                'dept_id' => '2'
            ],
            [
                'prog_id' => '8',
                'prog_code' => 'BSPsych',
                'prog_name' =>  'BS Psychology',
                'dept_id' => '2'
            ],
            [
                'prog_id' => '9',
                'prog_code' => 'BSCS',
                'prog_name' =>  'BS Computer Science',
                'dept_id' => '3'
            ],
            [
                'prog_id' => '10',
                'prog_code' => 'BSCpE',
                'prog_name' =>  'BS Computer Engineering',
                'dept_id' => '3'
            ],
            [
                'prog_id' => '11',
                'prog_code' => 'BIT',
                'prog_name' =>  'Bachelor in Industrial Technology',
                'dept_id' => '4'
            ],
            [
                'prog_id' => '12',
                'prog_code' => 'BSN',
                'prog_name' =>  'BS Nursing',
                'dept_id' => '5'
            ],
            [
                'prog_id' => '13',
                'prog_code' => 'BSND',
                'prog_name' =>  'BS Nutrition and Dietetics',
                'dept_id' => '5'
            ],
            [
                'prog_id' => '14',
                'prog_code' => 'BSEd',
                'prog_name' =>  'Bachelor of Secondary Education',
                'dept_id' => '6'
            ],
            [
                'prog_id' => '15',
                'prog_code' => 'BEEd',
                'prog_name' =>  'Bachelor of Elementary Education',
                'dept_id' => '6'
            ],
            [
                'prog_id' => '16',
                'prog_code' => 'BSIT',
                'prog_name' =>  'BS Information Technology',
                'dept_id' => '7'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('program');
    }
}
