<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('session_answers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('session_id');
            $table->integer('session_question_id');
            $table->integer('answer_id');
            $table->boolean('choosen');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('session_answers');
    }
}
