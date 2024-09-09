<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAisladosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aislados', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha_registro')->nullable();
            $table->string('dni',8)->nullable();
            $table->string('cip',8)->nullable();
            $table->string('nombres',100)->nullable();
            $table->string('apellido_paterno',50)->nullable();
            $table->string('apellido_materno',50)->nullable();
            $table->string('sexo',1)->nullable();
            $table->string('fecha_nacimiento',12)->nullable();
            $table->string('grado',50)->nullable();
            $table->integer('id_departamento')->unsigned()->nullable();
            $table->integer('id_provincia')->unsigned()->nullable();
            $table->integer('id_distrito')->unsigned()->nullable();
            $table->string('email',100)->nullable();            
            $table->string('celular',20)->nullable();            
            $table->string('domicilio',200)->nullable();
            $table->integer('id_pnpcategoria')->unsigned()->nullable();  
            $table->integer('id_factor')->unsigned()->nullable();  
            $table->integer('id_riesgo')->unsigned()->nullable();  
            $table->string('riesgo',50)->nullable();
            $table->string('dj',2)->nullable();
            $table->string('atencion',2)->nullable();
            $table->string('trabajo_remoto',2)->nullable();
            $table->date('fecha_aislamiento')->nullable();   
            $table->string('reincorporacion',2)->nullable();
            $table->string('informe',2)->nullable();
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
        Schema::drop('aislados');
    }
}
