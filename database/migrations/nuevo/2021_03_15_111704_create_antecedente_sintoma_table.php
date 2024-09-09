<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAntecedenteSintomaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antecedente_sintoma', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('antecedente_id')->unsigned();
            $table->integer('sintoma_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();            
            $table->foreign('antecedente_id')->references('id')->on('antecedentes');
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
        Schema::dropIfExists('antecedente_sintoma');
    }
}
