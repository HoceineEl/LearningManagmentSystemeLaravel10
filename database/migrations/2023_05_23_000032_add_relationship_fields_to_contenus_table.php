<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToContenusTable extends Migration
{
    public function up()
    {
        Schema::table('contenus', function (Blueprint $table) {
            $table->unsignedBigInteger('lecon_id')->nullable();
            $table->foreign('lecon_id', 'lecon_fk_8521664')->references('id')->on('lecons');
        });
    }
}
