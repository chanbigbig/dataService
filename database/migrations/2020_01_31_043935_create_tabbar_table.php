<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabbarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabbar', function (Blueprint $table) {
            $table->increments('id');
            $table->string('service_mobile')->default('')->comment('服务电话');
            $table->string('service_time')->default('')->comment('服务时间');
            $table->string('usa_mobile')->comment('美国电话');
            $table->string('shanghai_mobile')->comment('上海电话');
            $table->string('guangzhou_mobile')->comment('广州电话');
            $table->string('email')->comment('邮件');
            $table->string('address')->comment('地址');
            $table->string('mini_program_url')->comment('小程序图片地址');

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
        Schema::dropIfExists('tabbar');
    }
}
