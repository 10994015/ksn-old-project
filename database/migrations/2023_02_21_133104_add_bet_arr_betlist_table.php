<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBetArrBetlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('betlist', function (Blueprint $table) {
            $table->json('bet_arr')->nullable();
            $table->integer('final')->nullable();
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
            $table->dropColumn('bet_arr');
            $table->dropColumn('final');
        });
    }
}
