<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacationGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacation_goals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user');
            $table->unsignedInteger('type');
            $table->double('cost')->nullable();
            $table->unsignedInteger('time_frame')->nullable();
            $table->double('saving_goals')->nullable();
            $table->double('contribution')->nullable();
            $table->double('balance')->nullable();
            $table->unsignedInteger('reached')->nullable();
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
        Schema::dropIfExists('vacation_goals');
    }
}
