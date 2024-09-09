<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAntecedentesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         
        Schema::create('antecedentes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_clasificacion')->unsigned()->nullable(); 
            $table->integer('id_establecimiento')->unsigned()->nullable();            
            $table->string('fecha_registro',12)->nullable();
            $table->integer('id_user')->unsigned()->nullable();
            $table->string('dni',8)->nullable();
            //antecedente
            $table->string('fecha_sintoma',12)->nullable();
            $table->string('fecha_aislamiento',12)->nullable();
            $table->integer('id_departamento2')->unsigned()->nullable();
            $table->integer('id_provincia2')->unsigned()->nullable();
            $table->integer('id_distrito2')->unsigned()->nullable();
            $table->string('otro_sintoma',50)->nullable(); 
            $table->string('otro_signo',50)->nullable(); 
            $table->string('otro_factor',50)->nullable();
            $table->string('otra_ocupacion',50)->nullable(); 
            $table->string('contacto_directo',2)->unsigned()->nullable();
            $table->string('ficha_contacto',2)->nullable();
            $table->string('caso_reinfeccion',2)->nullable();
            $table->integer('ubicacion_hospitalizacion')->unsigned()->nullable();
            $table->string('indicacion',1000)->nullable();
            $table->string('motivo',1000)->nullable();
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
        Schema::drop('antecedentes');
    }
}
