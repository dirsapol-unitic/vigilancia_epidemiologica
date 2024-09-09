<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBdPnpaisladosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_pnpaislados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cip',8)->nullable();
            $table->string('dni',8)->nullable();
            $table->string('grado',50)->nullable();
            $table->string('especialidad',150)->nullable();
            $table->string('situacion',150)->nullable();
            $table->string('nombres',100)->nullable();            
            $table->string('sexo',20)->nullable();
            $table->string('fecha_nacimiento',12)->nullable();
            $table->integer('edad')->nullable();
            $table->string('cargo',200)->nullable();   
            $table->string('unidad',200)->nullable(); 
            $table->string('domicilio',200)->nullable();     
            $table->string('celular',50)->nullable(); 
            $table->string('motivo_aislamiento',150)->nullable();
            $table->string('aislamiento_detalle',150)->nullable();
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
        Schema::drop('bd_pnpaislados');
    }
}
