<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryMedicineBrandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_medicine_brand', function (Blueprint $table) {
            $table->id('imb_id');
            $table->string('imb_brand');
            $table->boolean('imb_status');
        });

        DB::table('inventory_medicine_brand')->insert([
            [
                'imb_id' => '1',
                'imb_brand' => 'none',
                'imb_status' => '1'
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
        Schema::dropIfExists('inventory_medicine_brand');
    }
}
