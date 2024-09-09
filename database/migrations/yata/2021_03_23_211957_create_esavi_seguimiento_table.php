<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEsaviSeguimientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('esavi_seguimiento', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('esavi_id')->nullable()->unsigned();
            $table->foreign('esavi_id')->references('id')->on('esavis');
            $table->integer('seguimiento_id')->nullable()->unsigned();
            $table->foreign('seguimiento_id')->references('id')->on('seguimientos');
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('esavi_seguimiento');
    }
}
