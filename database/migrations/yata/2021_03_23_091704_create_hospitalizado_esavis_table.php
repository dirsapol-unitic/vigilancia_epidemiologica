<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHospitalizadoEsavisTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         
        Schema::create('hospitalizado_esavis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('paciente_id')->unsigned()->nullable();
            $table->integer('esavi_id')->unsigned()->nullable();
            $table->string('paciente_dni',8)->unsigned()->nullable();
            $table->string('fecha_registro',12)->nullable();
            $table->string('fecha_ingreso',12)->unsigned()->nullable();
            $table->string('fecha_alta',12)->unsigned()->nullable();
            $table->integer('estado_alta')->unsigned()->default(1);
            $table->integer('transferido')->unsigned()->default(1);
            $table->string('detalle_transferido',500)->nullable();
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
        Schema::drop('hospitalizado_esavis');
    }
}
