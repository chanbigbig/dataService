<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('is_show_homepage')->default(0)->comment('是否显示在首页二级菜单 0 不显示 1显示');
            $table->string('img_url', 128)->default('')->comment('图片地址');
            $table->string('name')->default('')->comment('名称');
            $table->string('summary', 256)->comment('摘要');
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
        Schema::dropIfExists('team');
    }
}
