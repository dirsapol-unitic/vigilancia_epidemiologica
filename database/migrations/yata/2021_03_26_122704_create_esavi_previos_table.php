<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEsaviPreviosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('esavi_previos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('esavi_id')->unsigned();
            $table->integer('previo_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();            
            $table->foreign('esavi_id')->references('id')->on('esavis');
            $table->foreign('previo_id')->references('id')->on('previos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('esavi_previos');
    }
}
