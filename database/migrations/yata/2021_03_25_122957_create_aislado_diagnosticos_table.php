<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAisladoDiagnosticosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aislado_diagnosticos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_aislado')->nullable()->unsigned();
            $table->foreign('id_aislado')->references('id')->on('aislados');
            $table->integer('id_diagnostico')->nullable()->unsigned();
            $table->foreign('id_diagnostico')->references('id')->on('diagnosticos');
            $table->integer('tipo_diagnostico')->nullable()->unsigned();
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
