<?php

use Database\Libs\BlueprintTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   use BlueprintTrait;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_definitive_register_tokens', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('id');
            $table->unsignedBigInteger('user_id');
            $table->string('token', 256)->comment('トークン');
            $table->boolean('is_verify')->default(false)->comment('認証したか');
            $table->dateTime('expired_at')->comment('有効期限');
            $this->dateTimes($table);

            $table->foreign('user_id')->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_definitive_register_tokens');
    }
};
