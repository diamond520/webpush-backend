<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSuccessFailureToPushListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('push_list', function (Blueprint $table) {
            $table->integer('success')->default(0)->after('pusher_id');
            $table->integer('failure')->default(0)->after('success');
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
            $table->dropColumn(['success', 'failure']);
        });
    }
}
