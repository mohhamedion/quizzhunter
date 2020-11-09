<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TestRate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      
        Schema::create('test_rate', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer("rate");
            $table->integer("user_id");
            $table->integer("test_id");
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
