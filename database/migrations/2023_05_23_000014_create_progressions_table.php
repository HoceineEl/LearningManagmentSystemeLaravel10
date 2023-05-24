<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgressionsTable extends Migration
{
    public function up()
    {
        Schema::create('progressions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('est_complete')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
