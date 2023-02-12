<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnouncementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcement', function (Blueprint $table) {
            $table->id('anm_id');
            $table->string('anm_title');
            $table->longText('anm_body');
            $table->date('anm_active_until');
            $table->timestamp('anm_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('anm_creator_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announcement');
    }
}
