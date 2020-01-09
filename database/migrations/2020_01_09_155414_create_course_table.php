<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('course', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('img_url', 128)->default('')->comment('图片地址');
            $table->string('title')->default('')->comment('标题');
            $table->string('content')->default('')->comment('内容');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course');
    }
}
