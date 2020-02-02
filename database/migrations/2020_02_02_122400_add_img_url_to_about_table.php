<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImgUrlToAboutTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('about', function (Blueprint $table)
        {
            $table->string('img_url')->comment('内容图片');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('about', function (Blueprint $table)
        {
            $table->dropColumn('img_url');
        });
    }
}
