<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryEquipmentUpdateConditionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_equipment_update_condition', function (Blueprint $table) {
            $table->id('ieuc_id');
            $table->date('ieuc_date');
            $table->string('ieuc_to_condition');
            $table->string('ieuc_from_condition')->nullable();
            $table->boolean('is_deleted')->default(0);
            $table->integer('iep_id');
            $table->integer('iei_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_equipment_update_condition');
    }
}
