<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBetListColumnOkStore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('betlist', function (Blueprint $table) {
            $table->boolean('ok_store_money')->nullable()->comment('確定贏錢是否有入帳');
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
            $table->dropColumn('ok_store_money');
        });
    }
}
