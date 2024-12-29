<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertifiedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certified', function (Blueprint $table) {
            $table->id();
            $table->string('card_front')->nullable();
            $table->string('card_back')->nullable();
            $table->string('number_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
        Schema::create('certified_book', function (Blueprint $table) {
            $table->id();
            $table->string('passbook_cover')->nullable();
            $table->string('bank')->nullable();
            $table->string('bank_branches')->nullable();
            $table->string('passbook_account_name')->nullable();
            $table->string('passbook_account')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certified');
        Schema::dropIfExists('certified_book');
    }
}
