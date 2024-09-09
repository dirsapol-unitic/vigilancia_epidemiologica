<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateResultadosTable extends Migration
{
   public function up()
    {
        Schema::create('resultados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion',100)->nullable();
            $table->integer('prueba_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('prueba_id')->references('id')->on('pruebas');  
        });
    }

    public function down()
    {
        Schema::drop('resultados');
    }
}
