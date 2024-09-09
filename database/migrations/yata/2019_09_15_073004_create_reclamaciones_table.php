<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReclamacionesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reclamaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha_registro')->nullable();
            $table->date('fecha_reclamacion')->nullable();
            $table->string('nro_reclamacion',20)->nullable();            
            $table->integer('id_establecimiento')->unsigned()->nullable();
            $table->string('tipo_doc',10)->nullable();
            $table->string('nro_doc',200)->nullable();
            $table->string('nombres',100)->nullable();
            $table->string('apellido_paterno',50)->nullable();
            $table->string('apellido_materno',50)->nullable();
            $table->string('domicilio',200)->nullable();
            $table->integer('id_departamento')->unsigned()->nullable();
            $table->integer('id_provincia')->unsigned()->nullable();
            $table->integer('id_distrito')->unsigned()->nullable();
            $table->string('email',100)->nullable();            
            $table->string('celular',20)->nullable();
            $table->string('tipo_doc2',10)->nullable();
            $table->string('nro_doc2',200)->nullable();
            $table->string('nombres2',100)->nullable();
            $table->string('apellido_paterno2',50)->nullable();
            $table->string('apellido_materno2',50)->nullable();
            $table->string('domicilio2',200)->nullable();
            $table->integer('id_departamento2')->unsigned()->nullable();
            $table->integer('id_provincia2')->unsigned()->nullable();
            $table->integer('id_distrito2')->unsigned()->nullable();
            $table->string('email2',100)->nullable();            
            $table->string('celular2',20)->nullable();
            $table->string('reclamo',1000)->nullable();
            $table->string('autorizar_envio',5)->nullable();
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
        Schema::drop('reclamaciones');
    }
}
