<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHeadPictureTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('head_picture', function (Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedTinyInteger('type')->default(0)->comment('类型');
            $table->string('img_url', 128)->default('')->comment('图片地址');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('head_picture');
    }
}
