<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToVideosTable extends Migration
{
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->unsignedBigInteger('contenu_id')->nullable();
            $table->foreign('contenu_id', 'contenu_fk_8521681')->references('id')->on('contenus');
        });
    }
}
