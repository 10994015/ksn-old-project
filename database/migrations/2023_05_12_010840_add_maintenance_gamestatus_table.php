<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaintenanceGamestatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gamestatus', function (Blueprint $table) {
            $table->integer('maintenance')->default(0)->comment('是否維護中');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gamestatus', function (Blueprint $table) {
            $table->dropColumn('maintenance');
        });
    }
}
