<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiagnosticoHospitalizadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnostico_hospitalizados', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_hospitalizado')->nullable()->unsigned();
            $table->foreign('id_hospitalizado')->references('id')->on('hospitalizados');
            $table->integer('id_diagnostico')->nullable()->unsigned();
            $table->foreign('id_diagnostico')->references('id')->on('diagnosticos');
            $table->integer('tipo_diagnostico')->nullable()->unsigned();
            $table->integer('ingreso_egreso')->nullable()->unsigned();
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('aislado_diagnosticos');
    }
}
