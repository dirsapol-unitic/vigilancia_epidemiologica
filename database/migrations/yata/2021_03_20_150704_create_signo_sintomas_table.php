<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSignoSintomasTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         
        Schema::create('signo_sintomas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_aislado')->unsigned()->nullable(); 
            $table->string('dni',8)->nullable();
            $table->string('fecha_registro',12)->nullable();
            $table->integer('id_user_registro')->unsigned()->nullable();
            $table->integer('pregunta_id')->unsigned()->nullable();
            $table->integer('respuesta_id')->unsigned()->nullable();
            $table->integer('minuto')->unsigned()->nullable();
            $table->integer('hora')->unsigned()->nullable();
            $table->integer('dia')->unsigned()->nullable();
            $table->string('fecha_inicio',12)->nullable();
            $table->string('fecha_termino',12)->nullable();
            $table->integer('estado')->unsigned()->default(1);
            $table->integer('id_user_actualizacion')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('signo_sintomas');
    }
}
