<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeconsTable extends Migration
{
    public function up()
    {
        Schema::create('lecons', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->integer('position');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
