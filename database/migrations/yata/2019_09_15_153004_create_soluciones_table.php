<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSolucionesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soluciones', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('id_reclamo')->unsigned()->nullable();
            $table->integer('id_establecimiento')->unsigned()->nullable();
            $table->string('personal_solucionador',200)->nullable();
            $table->string('trato_directo',2)->nullable();            
            $table->date('fecha_solucion')->nullable();
            $table->date('fecha_registro')->nullable();
            $table->string('nro_doc',200)->nullable();            
            $table->string('nro_notificacion',200)->nullable();
            $table->integer('estado_reclamo')->unsigned()->nullable();
            $table->integer('resultado_reclamo')->unsigned()->nullable();
            $table->string('solucion_rpta',1000)->nullable();
            $table->string('ano_reclamacion',4)->nullable();
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
        Schema::drop('soluciones');
    }
}
