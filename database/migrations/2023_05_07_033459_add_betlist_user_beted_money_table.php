<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBetlistUserBetedMoneyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('betlist', function (Blueprint $table) {
            $table->integer('beted_money')->nullable()->comment('下注後的會員金額');
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
            $table->dropColumn('beted_money');
        });
    }
}
