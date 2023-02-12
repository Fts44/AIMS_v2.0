<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryEquipmentBrandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_equipment_brand', function (Blueprint $table) {
            $table->id('ieb_id');
            $table->string('ieb_brand');
            $table->boolean('ieb_status');
        });

        DB::table('inventory_equipment_brand')->insert([
            [
                'ieb_id' => '1',
                'ieb_brand' => 'none',
                'ieb_status' => '1'
            ],
            [
                'ieb_id' => '2',
                'ieb_brand' => 'baxtel',
                'ieb_status' => '1'
            ],
            [
                'ieb_id' => '3',
                'ieb_brand' => 'avent',
                'ieb_status' => '1'
            ],
            [
                'ieb_id' => '4',
                'ieb_brand' => 'samsung',
                'ieb_status' => '1'
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
        Schema::dropIfExists('inventory_equipment_brand');
    }
}
