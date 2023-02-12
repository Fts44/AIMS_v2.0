<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTitleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('title', function (Blueprint $table) {
            $table->id('ttl_id');
            $table->string('ttl_title');
        });

        DB::table('title')->insert([
            [
                'ttl_id' => 1,
                'ttl_title' => 'Mr'
            ],
            [
                'ttl_id' => 2,
                'ttl_title' => 'Ms'
            ],
            [
                'ttl_id' => 3,
                'ttl_title' => 'Mrs'
            ],
            [
                'ttl_id' => 4,
                'ttl_title' => 'Dr'
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
        Schema::dropIfExists('title');
    }
}
