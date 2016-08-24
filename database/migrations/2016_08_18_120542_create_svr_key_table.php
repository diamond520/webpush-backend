<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSvrKeyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('svr_key', function (Blueprint $table) {
            $table->increments('id');
            $table->string('svr_key');
            $table->string('sender_id');
            $table->timestamp('created_at');
        });
        DB::table('svr_key')->insert(array('svr_key' => 'AIzaSyAnqDQhjNQiXO_PdO6-uU5uFH6reH6Cims', 'sender_id' => '926974294337') );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('svr_key');
    }
}
