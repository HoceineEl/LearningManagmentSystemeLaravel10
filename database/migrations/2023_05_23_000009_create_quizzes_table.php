<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizzesTable extends Migration
{
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom');
            $table->foreignId('lesson_id')->constrained('lessons')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
