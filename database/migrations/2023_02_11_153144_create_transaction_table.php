<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->id('trans_id');
            $table->date('trans_date');
            $table->time('trans_time_in')->default(DB::raw('CURRENT_TIMESTAMP(0)'));;
            $table->time('trans_time_out')->nullable();
            $table->string('trans_patient_name');
            $table->string('trans_department')->nullable();
            $table->string('trans_srcode')->nullable();
            $table->string('trans_program')->nullable();
            $table->string('trans_classification')->nullable();
            $table->string('trans_purpose');
            $table->string('trans_purpose_specify')->nullable();
            $table->integer('trans_attachements')->nullable();
            $table->string('trans_result')->nullable();
            $table->integer('acc_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction');
    }
}
