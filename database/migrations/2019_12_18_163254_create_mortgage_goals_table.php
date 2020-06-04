<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMortgageGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mortgage_goals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user');
            $table->unsignedInteger('type');
            $table->double('est_appraised_value')->nullable();
            $table->double('down_payment_percent')->nullable();
            $table->double('down_payment')->nullable();
            $table->double('loan_amount')->nullable();
            $table->double('purpose')->nullable();
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
        Schema::dropIfExists('mortgage_goals');
    }
}
