<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAntecedenteOcupacioneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antecedente_ocupacione', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('antecedente_id')->unsigned();
            $table->integer('ocupacione_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();            
            $table->foreign('antecedente_id')->references('id')->on('antecedentes');
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
        Schema::dropIfExists('antecedente_ocupacione');
    }
}
