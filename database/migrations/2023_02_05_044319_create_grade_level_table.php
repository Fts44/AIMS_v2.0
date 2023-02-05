<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradeLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grade_level', function (Blueprint $table) {
            $table->id('gl_id');
            $table->string('gl_name');
        });

        DB::table('grade_level')->insert([
            [
                'gl_id' => '1',
                'gl_name' => 'Elementary'
            ],
            [
                'gl_id' => '2',
                'gl_name' => 'Junior High'
            ],
            [
                'gl_id' => '3',
                'gl_name' => 'Senior High'
            ],
            [
                'gl_id' => '4',
                'gl_name' => 'College'
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
        Schema::dropIfExists('grade_level');
    }
}
