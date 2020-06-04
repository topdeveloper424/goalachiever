<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('role');
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('name2')->nullable();
            $table->string('website')->nullable();
            $table->string('grade_type')->nullable();
            $table->boolean('educator')->default(false);
            $table->boolean('veteran')->default(false);
            $table->boolean('app_purchase')->default(false);
            $table->boolean('app_commission')->default(false);
            $table->boolean('representative')->default(false);
            $table->integer('donation')->nullable();
            $table->double('amount')->default(0);
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('rep')->nullable();
            $table->string('avatar')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }

}
