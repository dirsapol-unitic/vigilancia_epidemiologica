<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAislamientoSignosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aislamiento_signos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('aislamiento_id')->unsigned();
            $table->integer('signo_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();            
            $table->foreign('aislamiento_id')->references('id')->on('aislados');
            $table->foreign('signo_id')->references('id')->on('signos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aislamiento_signos');
    }
}
