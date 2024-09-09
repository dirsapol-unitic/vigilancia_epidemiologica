<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVacunasTable extends Migration
{
    public function up()
    {
        Schema::create('vacunas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('esavi_id')->unsigned();
            $table->integer('paciente_id')->unsigned();
            $table->string('dni_paciente',8);
            $table->string('nombre_vacuna',100);
            $table->string('adyuvante',20);
            $table->string('dosis',50);
            $table->string('via',50);
            $table->string('sitio',50);
            $table->string('fecha_vacunacion',12)->nullable();
            $table->string('nombre_ipress',200)->nullable();
            $table->string('fabricante',200)->nullable();
            $table->string('lote',200)->nullable();
            $table->string('fecha_expiracion',12)->nullable();
            $table->integer('estado')->default(1);
            $table->timestamps();
            $table->softDeletes();         
            $table->foreign('paciente_id')->references('id')->on('aislados');
            $table->foreign('esavi_id')->references('id')->on('esavis');
        });
    }

    public function down()
    {
        Schema::drop('vacunas');
    }
}