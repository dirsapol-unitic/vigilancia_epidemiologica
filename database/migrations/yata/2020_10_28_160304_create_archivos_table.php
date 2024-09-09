<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArchivosTable extends Migration
{
    public function up()
    {
        Schema::create('archivos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('aislado_id')->unsigned();
            $table->string('dni');
            $table->string('nombre_archivo');
            $table->string('descarga_archivo');
            $table->string('extension_archivo');
            $table->string('descripcion_archivo');
            $table->string('tipo_archivo');                   
            $table->integer('estado')->default(1);
            $table->timestamps();
            $table->softDeletes();                       
        });
    }

    public function down()
    {
        Schema::drop('archivos');
    }
}