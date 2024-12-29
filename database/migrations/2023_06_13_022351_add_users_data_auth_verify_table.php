<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsersDataAuthVerifyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('data_auth_verify')->default(0)->after('data_auth')->comment('身分證驗證中');
            $table->boolean('data_passbook_verify')->default(0)->after('data_auth_verify')->comment('銀行資料驗證中');
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
            $table->dropColumn('data_auth_verify');
            $table->dropColumn('data_passbook_verify');
        });
    }
}
