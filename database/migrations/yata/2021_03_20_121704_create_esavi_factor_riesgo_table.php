<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEsaviFactorRiesgoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('esavi_factor_riesgo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('esavi_id')->unsigned();
            $table->integer('factor_riesgo_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();            
            $table->foreign('esavi_id')->references('id')->on('esavis');
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
        Schema::dropIfExists('esavi_factor_riesgo');
    }
}
