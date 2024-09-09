<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExamenesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         
        Schema::create('examenes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_paciente')->unsigned()->nullable(); 
            $table->string('dni_paciente',8)->unsigned()->nullable();            
            $table->string('fecha_registro',12)->nullable();
            $table->string('fecha_muestra',12)->unsigned()->nullable();
            $table->integer('id_tipo_muestra')->nullable();
            $table->integer('id_tipo_prueba')->nullable();
            $table->string('fecha_resultado',12)->unsigned()->nullable();
            $table->integer('estado')->unsigned()->default(1);
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
        Schema::drop('examenes');
    }
}
