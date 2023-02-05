<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisabilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disability', function (Blueprint $table) {
            $table->id('dis_id');
            $table->string('disability');
        });

        DB::table('disability')->insert([
            [
                'dis_id' => '1',
                'disability' => 'Hearing'
            ],
            [
                'dis_id' => '2',
                'disability' => 'Intellectual'
            ],
            [
                'dis_id' => '3',
                'disability' => 'Orthopedic/ Physical'
            ],
            [
                'dis_id' => '4',
                'disability' => 'Speech Impairment'
            ],
            [
                'dis_id' => '5',
                'disability' => 'Visual Impairment'
            ],
            [
                'dis_id' => '6',
                'disability' => 'Psychosocial Impairment (Ex. Anxiety, Depression)'
            ],
            [
                'dis_id' => '7',
                'disability' => 'Others'
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
        Schema::dropIfExists('disability');
    }
}
