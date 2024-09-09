<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAislamientoLugareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aislamiento_lugare', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('aislamiento_id')->unsigned();
            $table->integer('lugare_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();            
            $table->foreign('aislamiento_id')->references('id')->on('aislados');
            $table->foreign('lugare_id')->references('id')->on('lugares');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aislamiento_lugare');
    }
}
