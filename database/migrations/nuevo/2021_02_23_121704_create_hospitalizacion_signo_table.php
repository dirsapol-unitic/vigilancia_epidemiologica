<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHospitalizacionSignoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospitalizacion_signo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hospitalizacion_id')->unsigned();
            $table->integer('signo_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();            
            $table->foreign('hospitalizacion_id')->references('id')->on('hospitalizados');
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
        Schema::dropIfExists('hospitalizacion_signo');
    }
}
