<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEvolucionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         
        Schema::create('evolucions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fecha_registro',12)->nullable();
            $table->integer('id_user')->unsigned()->nullable();
            $table->string('dni',8)->nullable();
            //evolucion
            $table->integer('evolucion')->unsigned()->nullable();
            $table->string('fecha_alta',12)->nullable();
            $table->integer('tipo_defuncion')->unsigned()->nullable();
            $table->string('fecha_deuncion',12)->nullable();
            $table->string('hora_defuncion',12)->nullable();
            $table->integer('lugar_defuncion')->unsigned()->nullable();
            $table->string('observacion',1000)->nullable();
            $table->string('otro_lugar_fallecimiento',1000)->nullable();
            $table->integer('hospital_fallecimiento')->nullable();
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
        Schema::drop('evolucions');
    }
}
