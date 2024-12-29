<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsersSubaccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('issub')->default(false);
        });
        Schema::create('subaccount', function (Blueprint $table) {
            $table->id();
            $table->boolean('proxy');
            $table->boolean('member');
            $table->boolean('store');
            $table->boolean('bet_record');
            $table->boolean('report');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('issub');
        });

        Schema::dropIfExists('subaccount');
    }
}
