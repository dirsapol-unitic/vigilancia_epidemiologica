<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMuestrasTable extends Migration
{
   public function up()
    {
        Schema::create('muestras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion',100)->nullable();            
            $table->timestamps();
            $table->softDeletes();            
        });
    }

    public function down()
    {
        Schema::drop('muestras');
    }
}
