<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAislamientoOcupacioneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aislamiento_ocupacione', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('aislamiento_id')->unsigned();
            $table->integer('ocupacione_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();            
            $table->foreign('aislamiento_id')->references('id')->on('aislados');
            $table->foreign('ocupacione_id')->references('id')->on('ocupaciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aislamiento_ocupacione');
    }
}
