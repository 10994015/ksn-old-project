<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorePointRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_point_record', function (Blueprint $table) {
            $table->id();
            $table->integer('money');
            $table->integer('store')->comment('上分:1, 下分:-1');
            $table->integer('store_type')->default(2)->comment('車商上分:1, 手動上分:2, 活動上分:3');
            $table->bigInteger('proxy_id')->comment('上下分操作人員ID');
            $table->bigInteger('member_id')->comment('會員ID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_point_record');
    }
}
