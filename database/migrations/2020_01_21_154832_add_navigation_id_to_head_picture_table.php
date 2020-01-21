<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNavigationIdToHeadPictureTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('head_picture', function (Blueprint $table)
        {
            $table->unsignedInteger('navigation_id')->default(0)->index();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('head_picture', function (Blueprint $table)
        {
            $table->dropColumn('navigation_id');
        });
    }
}
