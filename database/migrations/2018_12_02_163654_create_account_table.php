<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account', function (Blueprint $table) {
            $table->increments('id');
            $table->string('wxid', 32)->unique()->comment('微信账号唯一标识');
            $table->string('account', 32)->default('')->index('account')->comment('微信号');
            $table->string('nickname', 32)->default('')->comment('昵称');
            $table->unsignedTinyInteger('type')->default(0)->comment('类型，0普通客户 1熟客');
            $table->string('avatar', 225)->default('')->comment('头像');
            $table->unsignedInteger('mobile')->default(0)->index('mobile')->comment('手机号码');
            $table->unsignedTinyInteger('gender')->default(0)->comment('性别，0未知，1男，2女');
            $table->string('country', 32)->default('')->comment('国家');
            $table->string('province', 32)->default('')->comment('省份');
            $table->string('city', 32)->default('')->comment('城市');
            $table->string('sign', 64)->default('')->comment('签名');

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
        Schema::dropIfExists('account');
    }
}
