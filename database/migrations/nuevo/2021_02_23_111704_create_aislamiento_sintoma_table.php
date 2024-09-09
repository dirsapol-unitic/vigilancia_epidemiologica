<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAislamientoSintomaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aislamiento_sintoma', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('aislamiento_id')->unsigned();
            $table->integer('sintoma_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();            
            $table->foreign('aislamiento_id')->references('id')->on('aislados');
            $table->foreign('sintoma_id')->references('id')->on('sintomas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aislamiento_sintoma');
    }
}
