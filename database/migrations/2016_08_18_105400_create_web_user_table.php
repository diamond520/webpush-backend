<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('registation_id', 255)->unique()->comment = "gcm reg id";
            $table->boolean('state')->comment = "is subscribe: boolean";
            $table->string('channel')->default('0')->comment = "user channel, default 0";
            $table->string('device', 50)->nullable()->comment = "user device";
            $table->string('os', 50)->nullable()->comment = "device os";
            $table->string('os_version', 50)->nullable()->comment = "device os version";
            $table->string('browser', 50)->nullable()->comment = "device browser";
            $table->string('browser_version', 50)->nullable()->comment = "device browser version";
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
        Schema::drop('web_user');
    }
}
