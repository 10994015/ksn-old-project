<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnBetListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('betlist', function (Blueprint $table) {
            $table->json('bet_info')->comment('遊戲資訊')->nullable();
            $table->integer('topline')->nullable()->comment('此玩家的代理');
            $table->integer('game_type')->nullable()->comment('23:急速飛機');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('betlist', function (Blueprint $table) {
            $table->dropColumn('bet_info');
            $table->dropColumn('topline');
            $table->dropColumn('game_type');
        });
    }
}
