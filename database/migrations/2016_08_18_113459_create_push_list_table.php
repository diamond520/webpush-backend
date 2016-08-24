<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePushListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('push_list', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100)->comment = "push title";
            $table->string('body')->comment = "push body";
            $table->string('icon')->nullable()->comment = "icon url";
            $table->string('action')->nullable()->comment = "action url";
            $table->integer('pusher_id')->unsigned()->comment = "pusher";
            $table->foreign('pusher_id')->references('id')->on('pusher');
            $table->string('ip_address', 50)->nullable()->comment = "user login ip_address";
            $table->timestamp('updated_at');
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
        Schema::drop('push_list');
    }
}
