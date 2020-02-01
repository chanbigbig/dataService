<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFootPictureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foot_picture', function (Blueprint $table) {
            $table->increments('id');
            $table->string('img_url')->default('')->comment('图片地址');
            $table->string('remark')->default('')->comment('备注');
            $table->unsignedInteger('navigation_id')->default(0);
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
        Schema::dropIfExists('foot_picture');
    }
}
