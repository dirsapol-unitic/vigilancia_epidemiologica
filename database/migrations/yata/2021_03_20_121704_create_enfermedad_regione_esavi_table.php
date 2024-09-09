<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnfermedadRegioneEsaviTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enfermedad_regione_esavi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('esavi_id')->unsigned();
            $table->integer('enfermedad_regione_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();            
            $table->foreign('esavi_id')->references('id')->on('esavis');
            $table->foreign('enfermedad_regione_id')->references('id')->on('enfermedad_regiones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enfermedad_regione_esavi');
    }
}
