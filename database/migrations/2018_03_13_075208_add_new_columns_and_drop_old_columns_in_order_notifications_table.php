<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsAndDropOldColumnsInOrderNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_notifications', function (Blueprint $table) {
            $table->nullableMorphs('notifiable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_notifications', function (Blueprint $table) {
            $table->dropColumn('notifiable_id');
            $table->dropColumn('notifiable_type');
        });
    }
}
