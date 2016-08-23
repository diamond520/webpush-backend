<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePusherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pusher', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->unique()->comment = "login account";
            $table->string('password', 255)->comment = "passwd";
            $table->string('email', 255)->comment = "user email";
            $table->string('group', 50)->nullable()->comment = "user group";
            $table->string('ip_address', 50)->nullable()->comment = "user login ip_address";
            $table->rememberToken();
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
        Schema::drop('pusher');
    }
}
