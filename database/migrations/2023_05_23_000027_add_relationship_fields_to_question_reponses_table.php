<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToQuestionReponsesTable extends Migration
{
    public function up()
    {
        Schema::table('question_reponses', function (Blueprint $table) {
            $table->unsignedBigInteger('question_id')->nullable();
            $table->foreign('question_id', 'question_fk_8521184')->references('id')->on('quiz_questions');
        });
    }
}
