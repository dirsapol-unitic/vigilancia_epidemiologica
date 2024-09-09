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
            $table->string('nombre_dpto', 50)->nullable();
            $table->string('nombre_prov', 100)->nullable();
            $table->string('nombre_dist', 100)->nullable();
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
