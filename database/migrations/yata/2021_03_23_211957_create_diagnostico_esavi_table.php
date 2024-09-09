<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiagnosticoEsaviTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnostico_esavi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('aislado_id')->nullable()->unsigned();
            $table->foreign('aislado_id')->references('id')->on('aislados');
            $table->integer('diagnostico_id')->nullable()->unsigned();
            $table->foreign('diagnostico_id')->references('id')->on('diagnosticos');
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
        Schema::drop('diagnostico_esavi');
    }
}
