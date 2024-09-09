<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         
        Schema::create('contactos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_aislado')->unsigned()->nullable(); 
            $table->string('dni_aislado',8)->nullable();
            $table->string('fecha_registro',12)->nullable();
            $table->string('dni_contacto',8)->nullable();
            $table->string('nombres_contacto',100)->nullable();
            $table->string('paterno_contacto',50)->nullable();
            $table->string('materno_contacto',50)->nullable();
            $table->string('sexo_contacto',1)->nullable();
            $table->string('fecha_nacimiento_contacto',12)->nullable();
            $table->string('correo_contacto',50)->nullable();
            $table->string('telefono_contacto',20)->nullable();
            $table->string('domicilio_contacto',200)->nullable();
            $table->integer('id_departamento_contacto')->unsigned()->nullable();
            $table->integer('id_provincia_contacto')->unsigned()->nullable();            
            $table->integer('id_distrito_contacto')->unsigned()->nullable();
            $table->integer('tipo_contacto')->unsigned()->nullable();
            $table->string('tipo_contacto_sospechoso',50)->nullable();
            $table->string('fecha_contacto',12)->nullable();
            $table->string('fecha_cuarentena_contacto',12)->nullable();
            $table->string('contacto_sospechoso',2)->nullable();
            $table->string('otra_factor_riesgo',50)->nullable();
            //
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
