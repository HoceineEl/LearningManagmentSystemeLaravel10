<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionReponsesTable extends Migration
{
    public function up()
    {
        Schema::create('question_reponses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reponse');
            $table->boolean('est_correct')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
