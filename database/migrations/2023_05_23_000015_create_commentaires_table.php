<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentairesTable extends Migration
{
    public function up()
    {
        Schema::create('commentaires', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('commentaire')->nullable();
            $table->datetime('date_time')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
