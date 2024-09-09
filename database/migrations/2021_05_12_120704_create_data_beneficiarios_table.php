<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDataBeneficiariosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_beneficiarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dni',8)->nullable();
            $table->string('celular',50)->nullable();
            $table->integer('departamento_id')->unsigned()->nullable();
            $table->integer('establecimiento_proviene')->unsigned()->nullable();  
            $table->integer('establecimiento_actual')->unsigned()->nullable();  
            $table->integer('id_pnp_categoria')->unsigned()->nullable();
            $table->string('fecha_hospitalizacion',12)->nullable();
            $table->string('fallecido',20)->nullable();
            $table->string('hospitalizado',20)->nullable();
            $table->string('evolucion',20)->nullable();
            $table->string('ventilacion_mecanica',20)->nullable();
            $table->string('uci',20)->nullable();
            $table->string('obervacion',1000)->nullable();
            $table->integer('servicio_hospitalizacion')->nullable();
            $table->string('otro', 300)->nullable();
            $table->integer('clasificacion')->nullable();
            $table->integer('tipo_muestra')->nullable();
            $table->integer('tipo_prueba')->nullable();
            $table->integer('resultado')->nullable();
            $table->string('fecha_resultado',12)->nullable();
            $table->string('laboratorio', 2)->nullable();
            $table->string('neumonia', 2)->nullable();
            $table->string('fecha_alta', 100)->nullable();
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
        Schema::drop('data_beneficiarios');
    }
}
