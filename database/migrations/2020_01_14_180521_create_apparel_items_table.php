<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApparelItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apparel_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description');
            $table->string('ur_type');
            $table->double('unit_price');
            $table->double('cost');
            $table->double('net_profit');
            $table->double('profit_margin');
            $table->integer('quantity_sold');
            $table->double('total_net_profit');
            $table->double('quantity_in_stock');
            $table->double('inventory');
            $table->string('vendor');
            $table->double('total_cost');
            $table->double('shipping_cost');
            $table->double('weight');
            $table->double('back_order');

            $table->double('ur_credits');

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
            $table->integer('size_name');
            $table->unsignedInteger('size_1s')->default(0);
            $table->unsignedInteger('size_xs')->default(0);
            $table->unsignedInteger('size_s')->default(0);
            $table->unsignedInteger('size_m')->default(0);
            $table->unsignedInteger('size_l')->default(0);
            $table->unsignedInteger('size_xl')->default(0);
            $table->unsignedInteger('size_xxl')->default(0);
            $table->unsignedInteger('size_3xl')->default(0);
            $table->unsignedInteger('size_4xl')->default(0);
            $table->unsignedInteger('size_5xl')->default(0);

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
        Schema::dropIfExists('apparel_items');
    }
}
