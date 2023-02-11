<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientDocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_document', function (Blueprint $table) {
            $table->id('pd_id');
            $table->string('pd_filename');
            $table->string('pd_sys_filename');
            $table->dateTime('pd_date')->default(DB::raw('CURRENT_TIMESTAMP'));  
            $table->boolean('pd_verified_status')->default(0);
            $table->integer('dt_id');
            $table->integer('acc_id');
            $table->integer('uploaded_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_document');
    }
}
