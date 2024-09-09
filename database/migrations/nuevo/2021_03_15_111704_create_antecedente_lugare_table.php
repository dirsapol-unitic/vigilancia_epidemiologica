<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAntecedenteLugareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antecedente_lugare', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('antecedemte_id')->unsigned();
            $table->integer('lugare_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();            
            $table->foreign('antecedemte_id')->references('id')->on('antecedentes');
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
        Schema::dropIfExists('antecedente_lugare');
    }
}
