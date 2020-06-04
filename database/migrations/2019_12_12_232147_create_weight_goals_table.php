<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeightGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weight_goals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user');
            $table->unsignedInteger('type');
            $table->integer('desire_lose')->nullable();
            $table->integer('weight_start')->nullable();
            $table->integer('current_weight')->nullable();
            $table->integer('weight_lost')->nullable();
            $table->integer('achieved')->nullable();
            $table->boolean('status')->nullable();
            $table->integer('family')->nullable();
            $table->integer('desire')->nullable();
            $table->integer('health')->nullable();
            $table->integer('other')->nullable();
            $table->date('start_date')->nullable();
            $table->boolean('goal_achieved')->default(false);
            $table->boolean('cash_alert')->default(false);
            $table->boolean('credit_alert')->default(false);
            $table->dateTime('goal_achieved_time')->nullable();
            $table->dateTime('cash_alert_time')->nullable();
            $table->dateTime('credit_alert_time')->nullable();
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
        Schema::dropIfExists('weight_goals');
    }
}
