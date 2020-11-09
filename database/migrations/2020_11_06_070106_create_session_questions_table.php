<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('session_questions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('question_id');
            $table->integer('session_id');
            $table->boolean('answered')->default(false);
            $table->double('mark')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('session_questions');
    }
}
