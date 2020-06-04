<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoalBoostersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goal_boosters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user');
            $table->double('apparel')->nullable();
            $table->double('ultimate')->nullable();
            $table->double('scholarship')->nullable();
            $table->double('cash')->nullable();
            $table->double('ytd')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goal_boosters');
    }
}
