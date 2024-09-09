<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDerivadosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('derivados', function (Blueprint $table) {
            $table->increments('id');            
            $table->string('dni',8)->nullable();            
            $table->string('nombre_medico',200)->nullable();
            $table->string('celular',9)->nullable();
            $table->string('factor_anterior',50)->nullable();
            $table->string('factor_actual',50)->nullable();
            $table->integer('estado')->unsigned()->default(1);
            $table->string('dni_paciente',8)->nullable();            
            $table->integer('idaislado')->nullable();            
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
        Schema::drop('derivados');
    }
}
