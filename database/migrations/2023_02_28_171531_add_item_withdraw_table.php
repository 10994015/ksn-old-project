<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemWithdrawTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('withdraw', function (Blueprint $table) {
            $table->integer('store_type')->default(2)->comment('1=>違規下分, 2=>出款下分, 3=>活動下分')->after('status');
            $table->bigInteger('proxy_id')->nullable()->comment('操作人員')->after('store_type');
            $table->boolean('returned')->comment('已退回')->after('proxy_id')->default(false);
            $table->boolean('paidout')->comment('已出款')->after('returned')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('withdraw', function (Blueprint $table) {
            $table->dropColumn('store_type');
            $table->dropColumn('proxy_id');
            $table->dropColumn('returned');
            $table->dropColumn('paidout');
        });
    }
}
