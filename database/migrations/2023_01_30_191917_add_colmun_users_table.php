<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColmunUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('update_money_record', function (Blueprint $table) {
            $table->bigInteger('store_id')->nullable();
            $table->bigInteger('member_id')->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('recommender')->nullable()->comment('推薦人');
            $table->text('remark')->nullable()->comment('備註');
            $table->boolean('phone_verification')->after('phone')->default(false)->comment('手機是否驗證');
            $table->integer('total_money')->after('money')->default(0)->comment('累積儲值');
            $table->boolean('point_lock')->after('money')->default(false)->comment('錢包是否鎖定');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('update_money_record', function (Blueprint $table) {
            $table->dropColumn('store_id');
            $table->dropColumn('member_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('recommender');
            $table->dropColumn('remark');
            $table->dropColumn('phone_verification');
            $table->dropColumn('point_lock');
            $table->dropColumn('total_money');
        });
    }
}
