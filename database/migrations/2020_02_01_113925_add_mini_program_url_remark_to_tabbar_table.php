<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMiniProgramUrlRemarkToTabbarTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('tabbar', function (Blueprint $table)
        {
            $table->string('mini_program_url_remark')->comment('二维码备注');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('tabbar', function (Blueprint $table)
        {
            $table->dropColumn('mini_program_url_remark');
        });
    }
}
