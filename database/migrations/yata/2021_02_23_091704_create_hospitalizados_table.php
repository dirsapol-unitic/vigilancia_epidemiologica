<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHospitalizadosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         
        Schema::create('hospitalizados', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_paciente')->unsigned()->nullable(); 
            $table->string('dni_paciente',8)->unsigned()->nullable();            
            $table->string('fecha_registro',12)->nullable();
            $table->string('fecha_hospitalizacion',12)->unsigned()->nullable();
            $table->integer('id_establecimiento')->nullable();
            $table->string('tipo_seguro',100)->nullable();
            $table->string('otro_signo_ho',100)->nullable();
            $table->integer('servicio_hospitalizacion')->nullable();
            $table->integer('id_ventilacion_mecanica')->nullable();
            $table->integer('id_intubado')->nullable();
            $table->integer('id_neumonia')->nullable();
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
        Schema::drop('hospitalizados');
    }
}
