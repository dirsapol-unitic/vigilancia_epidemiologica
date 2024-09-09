<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateViasTable extends Migration
{
    public function up()
    {
        Schema::create('vias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion',100);
            $table->timestamps();
            $table->softDeletes();         
            
        });
    }

    public function down()
    {
        Schema::drop('vias');
    }
}