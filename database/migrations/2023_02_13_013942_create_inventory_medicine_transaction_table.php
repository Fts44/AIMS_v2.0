<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryMedicineTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_medicine_transaction', function (Blueprint $table) {
            $table->id('imt_id'); 
            $table->integer('acc_id')->nullable();
            $table->string('imt_type'); //dispose or dispense
            $table->integer('imt_quantity'); //how many dispose or dispense
            $table->string('imi_id'); //id of the item to dispose or dispense
            $table->timestamp('imt_date')->default(DB::raw('CURRENT_TIMESTAMP')); //current datetime
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_medicine_transaction');
    }
}
