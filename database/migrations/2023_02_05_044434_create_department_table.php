<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department', function (Blueprint $table) {
            $table->id('dept_id');
            $table->string('dept_code');
            $table->string('dept_name');
            $table->integer('gl_id');
        });

        DB::table('department')->insert([
            [
                'dept_id' => '1',
                'dept_code' => 'CABEIHM',
                'dept_name' => 'College of Accountancy, Business, Economics and International Hospitality Management',
                'gl_id' => '4'
            ],
            [
                'dept_id' => '2',
                'dept_code' => 'CAS',
                'dept_name' => 'College of Arts and Sciences',
                'gl_id' => '4'
            ],
            [
                'dept_id' => '3',
                'dept_code' => 'CECS',
                'dept_name' => 'College of Engineering and Computing Science',
                'gl_id' => '4'
            ],
            [
                'dept_id' => '4',
                'dept_code' => 'CIT',
                'dept_name' => 'College of Industrial Technology',
                'gl_id' => '4'
            ],
            [
                'dept_id' => '5',
                'dept_code' => 'CONAHS',
                'dept_name' => 'College of Nursing and Allied Health Sciences',
                'gl_id' => '4'
            ],
            [
                'dept_id' => '6',
                'dept_code' => 'CTE',
                'dept_name' => 'College of Teacher Education',
                'gl_id' => '4'
            ],
            [
                'dept_id' => '7',
                'dept_code' => 'CICS',
                'dept_name' => 'College of Informatics and Computing Sciences',
                'gl_id' => '4'
            ],
            [
                'dept_id' => '8',
                'dept_code' => 'STEM',
                'dept_name' => 'Science, Technology, Engineering and Mathematics.',
                'gl_id' => '3'
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
        Schema::dropIfExists('department');
    }
}
