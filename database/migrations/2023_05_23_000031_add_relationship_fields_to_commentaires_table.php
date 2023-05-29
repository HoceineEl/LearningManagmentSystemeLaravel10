<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCommentairesTable extends Migration
{
    public function up()
    {
        Schema::table('commentaires', function (Blueprint $table) {
            $table->unsignedBigInteger('lesson_id')->nullable();
            $table->foreign('lesson_id', 'lesson_fk_8521442')->references('id')->on('lessons');
            $table->unsignedBigInteger('utilisateur_id')->nullable();
            $table->foreign('utilisateur_id', 'utilisateur_fk_8521443')->references('id')->on('users');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id', 'parent_fk_8521468')->references('id')->on('commentaires');
        });
    }
}
