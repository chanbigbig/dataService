<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTabbarRemarkToTabbarTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('tabbar', function (Blueprint $table)
        {
            $table->string('remark')->comment('备注');
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
            $table->dropColumn('remark');
        });
    }
}
