<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryEquipmentPlaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_equipment_place', function (Blueprint $table) {
            $table->id('iep_id');
            $table->string('iep_place');
            $table->boolean('iep_status');
        });

        DB::table('inventory_equipment_place')->insert([
            [
                'iep_id' => '1',
                'iep_place' => 'none',
                'iep_status' => '1'
            ],
            [
                'iep_id' => '2',
                'iep_place' => 'Consultation Room',
                'iep_status' => '1'
            ],
            [
                'iep_id' => '3',
                'iep_place' => 'Lactation Room',
                'iep_status' => '1'
            ],
            [
                'iep_id' => '4',
                'iep_place' => 'Emergency Room',
                'iep_status' => '1'
            ],
            [
                'iep_id' => '5',
                'iep_place' => 'Infirmary Lobby',
                'iep_status' => '1'
            ],
            [
                'iep_id' => '6',
                'iep_place' => 'Records Room',
                'iep_status' => '1'
            ],
            [
                'iep_id' => '7',
                'iep_place' => 'Ward (Male)',
                'iep_status' => '1'
            ],
            [
                'iep_id' => '8',
                'iep_place' => 'Ward (Female)',
                'iep_status' => '1'
            ],
            [
                'iep_id' => '9',
                'iep_place' => 'Dental Room',
                'iep_status' => '1'
            ],
            [
                'iep_id' => '10',
                'iep_place' => 'Nursing Office',
                'iep_status' => '1'
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
        Schema::dropIfExists('inventory_equipment_place');
    }
}
