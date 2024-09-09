<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAisladosSintomasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aislados_sintomas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('aislados_id')->unsigned();
            $table->integer('factor_riesgo_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();            
            $table->foreign('aislados_id')->references('id')->on('aislados');
            $table->foreign('factor_riesgo_id')->references('id')->on('sintomas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aislados_factor_riesgo');
    }
}
