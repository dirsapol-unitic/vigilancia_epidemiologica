<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEsavisTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         
        Schema::create('esavis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_aislado')->unsigned()->nullable(); 
            $table->string('dni',8)->nullable();
            $table->string('fecha_registro',12)->nullable();
            $table->integer('id_user_registro')->unsigned()->nullable();
            //antecedente
            $table->string('fecha_notificacion',12)->nullable();
            $table->string('fecha_identificacion',12)->nullable();
            $table->string('fecha_investigacion',12)->nullable();
            $table->integer('tipo_esavi')->unsigned()->nullable();
            $table->integer('esavi_previo')->unsigned()->nullable();
            //
            $table->string('fecha_sintoma',12)->nullable();
            $table->integer('gravedad_caso')->nullable();
            $table->string('secuencia_cronologica',1200)->nullable();
            $table->string('examen_auxiliar',500)->nullable();
            $table->string('tratamiento_recibido',500)->nullable();
            $table->string('evolucion',200)->nullable();
            
            $table->integer('id_user_actualizacion')->unsigned()->nullable();
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
        Schema::drop('esavis');
    }
}
