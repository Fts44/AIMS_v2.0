<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryEquipmentItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_equipment_item', function (Blueprint $table) {
            $table->id('iei_id');
            $table->integer('iei_qty');
            $table->string('iei_condition');
            $table->date('iei_date_added');
            $table->integer('ieid_id');
            $table->integer('iep_id');
            $table->boolean('is_deleted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_equipment_item');
    }
}
