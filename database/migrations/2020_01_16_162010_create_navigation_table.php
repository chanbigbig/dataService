<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavigationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navigation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->default('')->comment('标题内容');
            $table->string('content')->default('')->comment('详情');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态 0 关闭 1 开启');
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
        Schema::dropIfExists('navigation');
    }
}
