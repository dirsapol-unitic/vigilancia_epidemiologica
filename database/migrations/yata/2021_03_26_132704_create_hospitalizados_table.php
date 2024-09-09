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
            $table->integer('id_user_registro'); 
            $table->integer('id_user_actualizacion')->unsigned()->nullable();
            $table->integer('id_user_alta')->unsigned()->nullable();
            $table->string('dni_paciente',8)->unsigned()->nullable();            
            $table->string('fecha_registro',12)->nullable();
            $table->integer('establecimiento_proviene')->nullable();
            $table->string('fecha_hospitalizacion',12)->unsigned()->nullable();
            $table->string('fecha_alta',12)->unsigned()->nullable();
            $table->string('alta_hospitalaria',2)->default('NO');
            $table->integer('establecimiento_actual')->nullable();
            $table->integer('establecimiento_alta')->nullable();
            $table->string('tipo_seguro',100)->nullable();
            $table->string('otro_signo_ho',100)->nullable();
            $table->integer('servicio_hospitalizacion')->nullable();
            $table->string('otra_ubicacion',100)->nullable();
            $table->integer('ventilacion_mecanica')->nullable();
            $table->integer('intubado')->nullable();
            $table->integer('neumonia')->nullable();
            $table->integer('uci')->nullable();
            $table->integer('estado')->unsigned()->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_user_registro')->references('id')->on('users');
            $table->foreign('id_user_actualizacion')->references('id')->on('users');
            $table->foreign('id_user_alta')->references('id')->on('users');
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
