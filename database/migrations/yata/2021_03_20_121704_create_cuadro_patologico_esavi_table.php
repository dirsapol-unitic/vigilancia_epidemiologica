<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuadroPatologicoEsaviTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuadro_patologico_esavi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('esavi_id')->unsigned();
            $table->integer('cuadro_patologico_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();            
            $table->foreign('esavi_id')->references('id')->on('esavis');
            $table->foreign('cuadro_patologico_id')->references('id')->on('cuadro_patologicos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cuadro_patologico_esavi');
    }
}
