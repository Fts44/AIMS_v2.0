<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryEquipmentNameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_equipment_name', function (Blueprint $table) {
            $table->id('ien_id');
            $table->string('ien_name');
            $table->boolean('ien_status');
        });

        DB::table('inventory_equipment_name')->insert([
            [
                'ien_id' => '1',
                'ien_name' => 'Airconditioner',
                'ien_status' => '1',
            ],
            [
                'ien_id' => '2',
                'ien_name' => 'Autoclave',
                'ien_status' => '1',
            ],
            [
                'ien_id' => '3',
                'ien_name' => 'Aluminum Crutch',
                'ien_status' => '1',
            ],
            [
                'ien_id' => '4',
                'ien_name' => 'Ambo bag',
                'ien_status' => '1',
            ],
            [
                'ien_id' => '5',
                'ien_name' => 'Aneroid Sphygmomanometer',
                'ien_status' => '1',
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
        Schema::dropIfExists('inventory_equipment_name');
    }
}
