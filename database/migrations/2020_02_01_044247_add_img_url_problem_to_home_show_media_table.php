<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImgUrlProblemToHomeShowMediaTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('home_show_media', function (Blueprint $table)
        {
            $table->string('problem')->comment('问题');
            $table->string('show_media_url')->comment('首页展现图片');
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
            $table->dropColumn(['problem', 'show_media_url']);
        });
    }
}
