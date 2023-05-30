<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToScoreQuizzesTable extends Migration
{
    public function up()
    {
        Schema::table('score_quizzes', function (Blueprint $table) {
            $table->unsignedBigInteger('lesson')->nullable();
            $table->foreign('lesson', 'lecon_fk_8521224')->references('id')->on('lessons');
            $table->unsignedBigInteger('quiz_id')->nullable();
            $table->foreign('quiz_id', 'quiz_fk_8521225')->references('id')->on('quizzes');
            $table->unsignedBigInteger('utilisateur_id')->nullable();
            $table->foreign('utilisateur_id', 'utilisateur_fk_8521226')->references('id')->on('users');
        });
    }
}
