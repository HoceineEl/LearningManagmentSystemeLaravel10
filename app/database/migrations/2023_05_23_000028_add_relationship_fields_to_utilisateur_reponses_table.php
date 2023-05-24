<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUtilisateurReponsesTable extends Migration
{
    public function up()
    {
        Schema::table('utilisateur_reponses', function (Blueprint $table) {
            $table->unsignedBigInteger('utilisateur_id')->nullable();
            $table->foreign('utilisateur_id', 'utilisateur_fk_8521191')->references('id')->on('users');
            $table->unsignedBigInteger('reponse_id')->nullable();
            $table->foreign('reponse_id', 'reponse_fk_8521192')->references('id')->on('question_reponses');
        });
    }
}
