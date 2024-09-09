<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEstablecimientosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('establecimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo_eess',200)->nullable();
            $table->string('cod_ipress',200)->nullable();            
            $table->string('nombre',200)->nullable();
            $table->integer('region')->nullable();            
            $table->integer('nivel')->unsigned()->nullable();
            $table->integer('categoria')->nullable();
            $table->integer('departamento')->nullable();
            $table->integer('provincia')->nullable();
            $table->integer('distrito')->nullable();
            $table->string('ubigeo',10)->nullable();
            $table->string('coddisa',20)->nullable();
            $table->string('disa',200)->nullable();
            $table->string('norte',200)->nullable();
            $table->string('este',200)->nullable();
            $table->string('cota',200)->nullable();
            $table->string('direccion',200)->nullable();
            $table->integer('estado')->default(1);
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
        Schema::drop('establecimientos');
    }
}
