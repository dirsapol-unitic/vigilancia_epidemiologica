<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVacunasTable extends Migration
{
    public function up()
    {
        Schema::create('vacunas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('paciente_id')->unsigned();
            $table->string('dni_paciente');
            $table->string('nombre_vacuna');
            $table->string('adyuvante');
            $table->string('dosis');
            $table->string('via');
            $table->string('sitio');
            $table->string('fecha_vacunacion',12)->nullable();
            $table->string('nombre_ipress',200)->nullable();
            $table->string('fabricante',200)->nullable();
            $table->string('lote',200)->nullable();
            $table->string('fecha_expiracion',12)->nullable();
            $table->integer('estado')->default(1);
            $table->timestamps();
            $table->softDeletes();         
            $table->foreign('paciente_id')->references('id')->on('aislados');
        });
    }

    public function down()
    {
        Schema::drop('vacunas');
    }
}