<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_course', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('is_show_homepage')->comment('是否显示在首页二级菜单 0 不显示 1显示');
            $table->string('img_url', 128)->default('')->comment('图片地址');
            $table->string('title')->default('')->comment('标题');
            $table->string('summary', 256)->comment('摘要');
            $table->text('content')->comment('内容');
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
        Schema::dropIfExists('history_course');
    }
}
