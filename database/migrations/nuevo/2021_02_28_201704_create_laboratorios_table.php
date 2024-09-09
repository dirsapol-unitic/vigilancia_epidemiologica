<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLaboratoriosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         
        Schema::create('laboratorios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_paciente')->unsigned()->nullable(); 
            $table->string('dni_paciente',8)->unsigned()->nullable();            
            $table->string('fecha_muestra',12)->nullable();
            $table->integer('tipo_muestra')->nullable();
            $table->integer('tipo_prueba')->nullable();
            $table->integer('resultado_muestra')->nullable();
            $table->string('fecha_resultado',12)->nullable();
            $table->string('enviado_minsa',2)->nullable();
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
        Schema::drop('laboratorios');
    }
}
