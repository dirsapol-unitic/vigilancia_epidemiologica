<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFielsToAisladosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aislados', function (Blueprint $table) {
            $table->integer('establecimiento_id')->unsigned()->nullable();
            $table->string('evolucion', 50)->default('SIN REGISTRO');
            $table->string('contacto', 2)->default('NO');
            $table->string('laboratorio', 2)->default('NO');
            $table->string('clasificacion', 50)->default('SIN REGISTRO');
            $table->string('vac_covid_primera', 2)->default('NO');
            $table->string('vac_covid_segunda', 2)->default('NO');
            $table->string('vacuna_covid', 2)->default('NO');
            $table->string('esavi', 2)->default('NO');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aislados', function (Blueprint $table) {
            //
        });
    }
}
