<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetirementGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retirement_goals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user');
            $table->unsignedInteger('type');
            $table->double('part1_cur_age')->nullable();
            $table->double('part1_re_age')->nullable();
            $table->double('part1_year_to_retire')->nullable();
            $table->double('part1_desire_income')->nullable();
            $table->double('part1_est_income')->nullable();
            $table->double('part1_re_funds')->nullable();
            $table->double('part1_contribution')->nullable();
            $table->double('part1_est_retire')->nullable();
            $table->double('part1_balance')->nullable();
            $table->double('part1_reached')->nullable();
            $table->double('part2_contributions')->nullable();
            $table->integer('part2_returns')->nullable();
            $table->integer('part2_years')->nullable();
            $table->double('part2_est_funds')->nullable();
            $table->double('part3_existing_amount')->nullable();
            $table->double('part3_previous_amount')->nullable();
            $table->double('part3_total')->nullable();
            $table->date('part3_start_date')->nullable();
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
        Schema::dropIfExists('retirement_goals');
    }
}
