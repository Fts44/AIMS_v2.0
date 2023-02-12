<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryMedicineItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_medicine_item', function (Blueprint $table) {
            $table->id('imi_id');
            $table->integer('imi_quantity');
            $table->integer('imb_id');
            $table->integer('imgn_id');
            $table->boolean('imi_status');
            $table->date('imi_expiration');
            $table->date('imi_date_added');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_medicine_item');
    }
}
