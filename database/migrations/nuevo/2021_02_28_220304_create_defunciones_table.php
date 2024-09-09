<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDefuncionesTable extends Migration
{
    public function up()
    {
        Schema::create('defunciones', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('aislado_id')->unsigned();                  
            $table->string('tipo_defuncion',10);  
            $table->string('nro_defuncion',20);  
            $table->string('fecha_defuncion',12);  
            $table->string('nombre_archivo',100);
            $table->string('descarga_archivo',100);       
            $table->string('extension_archivo',5);      
            $table->string('descripcion_archivo');
            $table->integer('estado')->default(1);
            $table->timestamps();
            $table->softDeletes();            
            $table->foreign('aislado_id')->references('id')->on('aislados');            
        });
    }

    public function down()
    {
        Schema::drop('defunciones');
    }
}