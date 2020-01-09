<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomeHistoryTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('home_history', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('img_url', 128)->default('')->comment('图片地址');
            $table->string('stats_num')->default('')->comment('统计数据');
            $table->string('content')->default('')->comment('备注');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('home_history');
    }
}
