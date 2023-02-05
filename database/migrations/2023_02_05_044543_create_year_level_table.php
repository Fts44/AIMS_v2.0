<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYearLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('year_level', function (Blueprint $table) {
            $table->id('yl_id');
            $table->string('yl_name');
            $table->string('gl_id');
        });

        DB::table('year_level')->insert([
            [
                'yl_id' => '1',
                'yl_name' => 'Daycare',
                'gl_id' => '1'
            ],
            [
                'yl_id' => '2',
                'yl_name' => 'Kinder',
                'gl_id' => '1'
            ],
            [
                'yl_id' => '3',
                'yl_name' => '1st',
                'gl_id' => '1'
            ],
            [
                'yl_id' => '4',
                'yl_name' => '2nd',
                'gl_id' => '1'
            ],
            [
                'yl_id' => '5',
                'yl_name' => '3rd',
                'gl_id' => '1'
            ],
            [
                'yl_id' => '6',
                'yl_name' => '4th',
                'gl_id' => '1'
            ],
            [
                'yl_id' => '7',
                'yl_name' => '5th',
                'gl_id' => '1'
            ],
            [
                'yl_id' => '8',
                'yl_name' => '6th',
                'gl_id' => '1'
            ],
            [
                'yl_id' => '9',
                'yl_name' => '7th',
                'gl_id' => '2'
            ],
            [
                'yl_id' => '10',
                'yl_name' => '8th',
                'gl_id' => '2'
            ],
            [
                'yl_id' => '11',
                'yl_name' => '9th',
                'gl_id' => '2'
            ],
            [
                'yl_id' => '12',
                'yl_name' => '10th',
                'gl_id' => '2'
            ],
            [
                'yl_id' => '13',
                'yl_name' => '11th',
                'gl_id' => '3'
            ],
            [
                'yl_id' => '14',
                'yl_name' => '12th',
                'gl_id' => '3'
            ],
            [
                'yl_id' => '15',
                'yl_name' => '1st',
                'gl_id' => '4'
            ],
            [
                'yl_id' => '16',
                'yl_name' => '2nd',
                'gl_id' => '4'
            ],
            [
                'yl_id' => '17',
                'yl_name' => '3rd',
                'gl_id' => '4'
            ],
            [
                'yl_id' => '18',
                'yl_name' => '4th',
                'gl_id' => '4'
            ],
            [
                'yl_id' => '19',
                'yl_name' => '5th',
                'gl_id' => '4'
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('year_level');
    }
}
