<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImpClickCTRToPushListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('push_list', function (Blueprint $table) {
            $table->integer('impression')->after('pusher_id');
            $table->integer('click')->after('impression');
            $table->integer('ctr')->after('click');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('push_list', function (Blueprint $table) {
            $table->dropColumn(['impression', 'click', 'ctr']);
        });
    }
}
