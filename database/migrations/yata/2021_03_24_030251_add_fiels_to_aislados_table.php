<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFielsToAisladosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aislados', function (Blueprint $table) {
            $table->string('fallecido', 2)->default('NO');
            $table->string('hospitalizado', 2)->default('NO');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aislados', function (Blueprint $table) {
            //
        });
    }
}
