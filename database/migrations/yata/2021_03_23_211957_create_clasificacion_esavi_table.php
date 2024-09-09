<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClasificacionEsaviTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clasificacion_esavi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('esavi_id')->nullable()->unsigned();
            $table->foreign('esavi_id')->references('id')->on('esavis');
            $table->integer('clasificacion_id')->nullable()->unsigned();
            $table->foreign('clasificacion_id')->references('id')->on('clasificaciones');
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
        Schema::drop('clasificacion_esavi');
    }
}
