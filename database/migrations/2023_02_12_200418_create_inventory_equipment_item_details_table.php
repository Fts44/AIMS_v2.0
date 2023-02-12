<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryEquipmentItemDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_equipment_item_details', function (Blueprint $table) {
            $table->id('ieid_id');
            $table->string('ieid_unit');
            $table->string('ieid_category');
            $table->boolean('ieid_status');
            $table->integer('ien_id');
            $table->integer('ieb_id');
            $table->integer('iet_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_equipment_item_details');
    }
}
