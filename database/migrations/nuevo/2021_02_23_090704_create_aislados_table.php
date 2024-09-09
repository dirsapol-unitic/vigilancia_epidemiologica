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
            $table->integer('id_clasificacion')->unsigned()->nullable(); 
            $table->integer('id_establecimiento')->unsigned()->nullable();            
            $table->string('fecha_registro',12)->nullable();
            $table->integer('id_user')->unsigned()->nullable();
            $table->string('dni',8)->nullable();
            $table->string('nombres',100)->nullable();
            $table->string('paterno',50)->nullable();
            $table->string('materno',50)->nullable();
            $table->string('cip',8)->nullable();
            $table->string('grado',50)->nullable();
            $table->string('sexo',1)->nullable();
            $table->string('fecha_nacimiento',12)->nullable();
            $table->integer('edad')->unsigned()->nullable(); 
            $table->string('telefono',20)->nullable();    
            $table->string('unidad',50)->nullable();
            $table->string('situacion',50)->nullable();    
            $table->integer('id_categoria')->unsigned()->nullable(); 
            $table->string('peso',10)->nullable();
            $table->string('talla',10)->nullable(); 
            $table->string('parentesco',20)->nullable(); 
            $table->integer('etnia')->unsigned()->nullable();
            $table->string('otra_raza',50)->nullable(); 
            $table->integer('nacionalidad')->unsigned()->nullable();
            $table->string('otra_nacion',50)->nullable(); 
            $table->integer('migrante')->unsigned()->nullable();
            $table->string('otro_migrante',50)->nullable(); 
            $table->string('domicilio',200)->nullable();
            $table->integer('id_departamento')->unsigned()->nullable();
            $table->integer('id_provincia')->unsigned()->nullable();
            $table->integer('id_distrito')->unsigned()->nullable();
            $table->string('fecha_sintoma',12)->nullable();
            $table->string('fecha_aislamiento',12)->nullable();
            $table->integer('id_departamento2')->unsigned()->nullable();
            $table->integer('id_provincia2')->unsigned()->nullable();
            $table->integer('id_distrito2')->unsigned()->nullable();
            $table->string('contacto_directo',100)->nullable();
            $table->integer('evolucion_paciente')->nullable();
            $table->string('fecha_alta',12)->nullable();
            $table->string('fecha_defuncion',12)->nullable();
            $table->string('hora_defuncion',12)->nullable();
            $table->integer('lugar_defuncion')->nullable();
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
