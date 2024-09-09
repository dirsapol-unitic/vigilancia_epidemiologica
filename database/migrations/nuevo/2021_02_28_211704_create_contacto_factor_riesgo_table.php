<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactoFactorRiesgoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacto_factor_riesgo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contacto_id')->unsigned();
            $table->integer('factor_riesgo_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();            
            $table->foreign('contacto_id')->references('id')->on('contactos');
            $table->foreign('factor_riesgo_id')->references('id')->on('factor_riesgos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacto_factor_riesgo');
    }
}
