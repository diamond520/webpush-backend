<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('impression_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('push_id')->unsigned()->comment = "push_id";
            $table->integer('web_user_id')->unsigned()->comment = "web_user_id";
            $table->foreign('push_id')->references('id')->on('push_list');
            $table->foreign('web_user_id')->references('id')->on('web_user');
            $table->timestamp('created_at');
        });
        Schema::create('click_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('push_id')->unsigned()->comment = "push_id";
            $table->integer('web_user_id')->unsigned()->comment = "web_user_id";
            $table->foreign('push_id')->references('id')->on('push_list');
            $table->foreign('web_user_id')->references('id')->on('web_user');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('impression_log');
        Schema::drop('click_log');    }
}
