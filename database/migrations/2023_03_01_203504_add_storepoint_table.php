<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStorepointTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store_point_record', function (Blueprint $table) {
            $table->string('order_number')->after('store_type')->nullable();
            $table->string('username')->after('order_number')->nullable();
            $table->integer('status')->after('username')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store_point_record', function (Blueprint $table) {
            $table->dropColumn('order_number');
            $table->dropColumn('username');
            $table->dropColumn('status');
        });
    }
}
