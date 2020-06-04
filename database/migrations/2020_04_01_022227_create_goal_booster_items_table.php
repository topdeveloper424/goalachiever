<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoalBoosterItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goal_booster_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description');
            $table->string('plan_type');
            $table->double('purchase_price');
            $table->double('purchased_credits');
            $table->double('net_profit');
            $table->string('qty_purchased');
            $table->double('total_purchased_credits');
            $table->double('total_net_profit');
            $table->double('total_qty_purchased');

            $table->double('member');
            $table->double('ur_25k');
            $table->double('ur_monthly');
            $table->double('ur_sponsor');
            $table->double('ur_participant');
            $table->double('achiever_alerts');
            $table->double('admin');
            $table->double('scholarship');
            $table->double('school_donations');
            $table->double('charity');
            $table->double('rep');
            $table->double('goal_achiever');

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
        Schema::dropIfExists('goal_booster_items');
    }
}
