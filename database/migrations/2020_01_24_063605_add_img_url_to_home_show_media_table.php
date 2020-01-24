<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImgUrlToHomeShowMediaTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('home_show_media', function (Blueprint $table)
        {
            $table->string('img_url')->default('')->comment('封面图片地址');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('home_show_media', function (Blueprint $table)
        {
            $table->dropColumn('img_url');
        });
    }
}
