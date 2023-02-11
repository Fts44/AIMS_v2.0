<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_type', function (Blueprint $table) {
            $table->id('dt_id');
            $table->string('dt_name');
        });

        DB::table('document_type')->insert([
            [
                'dt_id' => '1',
                'dt_name' => 'Covid VaxCert'
            ],
            [
                'dt_id' => '2',
                'dt_name' => 'Covid Insurance'
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
        Schema::dropIfExists('document_type');
    }
}
