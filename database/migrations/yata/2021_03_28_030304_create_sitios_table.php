<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSitiosTable extends Migration
{
    public function up()
    {
        Schema::create('sitios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion',100);
            $table->timestamps();
            $table->softDeletes();         
            
        });
    }

    public function down()
    {
        Schema::drop('sitios');
    }
}