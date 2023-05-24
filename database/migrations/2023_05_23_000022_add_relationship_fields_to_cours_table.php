<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCoursTable extends Migration
{
    public function up()
    {
        Schema::table('cours', function (Blueprint $table) {
            $table->unsignedBigInteger('auteur_id')->nullable();
            $table->foreign('auteur_id', 'auteur_fk_8518408')->references('id')->on('users');
        });
    }
}
