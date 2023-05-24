<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToQuizQuestionsTable extends Migration
{
    public function up()
    {
        Schema::table('quiz_questions', function (Blueprint $table) {
            $table->unsignedBigInteger('quiz_id')->nullable();
            $table->foreign('quiz_id', 'quiz_fk_8521131')->references('id')->on('quizzes');
        });
    }
}
