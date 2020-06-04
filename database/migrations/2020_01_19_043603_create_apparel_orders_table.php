<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApparelOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apparel_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_number');
            $table->dateTime('order_date');
            $table->unsignedInteger('purchaser_id')->nullable();
            $table->unsignedInteger('member_id')->nullable();
            $table->unsignedInteger('rep_id')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('shipping_from')->nullable();
            $table->text('from_address')->nullable();
            $table->string('from_city')->nullable();
            $table->string('from_state')->nullable();
            $table->string('from_zip')->nullable();
            $table->string('from_email')->nullable();
            $table->string('from_phone')->nullable();
            $table->string('shipping_to')->nullable();
            $table->text('to_address')->nullable();
            $table->string('to_city')->nullable();
            $table->string('to_state')->nullable();
            $table->string('to_zip')->nullable();
            $table->string('to_email')->nullable();
            $table->string('to_phone')->nullable();
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
        Schema::dropIfExists('apparel_orders');
    }
}
