<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('id');
            $table->integer('user_id')->unique('UNQ_USER_ID')->comment('ユーザーID');
            $table->string('name')->comment('名前');
            $table->string('icon_url')->comment('アイコンURL');
            $table->string('password')->comment('パスワード');
            $table->string('access_token')->comment('アクセストークン');
            $table->boolean('is_registered')->default(0)->comment('登録フラグ');
            $table->boolean('del_flg')->default(0)->comment('削除フラグ');
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
        Schema::dropIfExists('users');
    }
}
