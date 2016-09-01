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
            $table->integer('impression')->default(0)->after('pusher_id');
            $table->integer('click')->default(0)->after('impression');
            $table->integer('ctr')->default(0)->after('click');
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
