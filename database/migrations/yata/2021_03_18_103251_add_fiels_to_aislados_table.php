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
            $table->string('age', 50)->nullable();
            $table->string('referencia', 300)->nullable();
            $table->integer('tipo_localidad')->nullable();
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
