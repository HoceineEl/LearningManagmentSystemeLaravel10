<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContenusTable extends Migration
{
    public function up()
    {
        Schema::create('contenus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ordre');
            $table->string('type')->nullable();
            $table->integer('id_type')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
