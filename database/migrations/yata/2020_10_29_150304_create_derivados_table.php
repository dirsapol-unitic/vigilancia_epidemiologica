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
            $table->string('nombres',100)->nullable();
            $table->string('apellido_paterno',50)->nullable();
            $table->string('apellido_materno',50)->nullable();
            $table->string('celular',9)->nullable();
            $table->string('factor_anterior',50)->nullable();
            $table->string('factor_actual',50)->nullable();
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
        Schema::drop('derivados');
    }
}
