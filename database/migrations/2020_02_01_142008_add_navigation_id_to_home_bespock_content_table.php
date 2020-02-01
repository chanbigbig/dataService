<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNavigationIdToHomeBespockContentTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('home_bespock_content', function (Blueprint $table)
        {
            $table->unsignedInteger('navigation_id')->default(0);
            $table->text('content')->change();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('home_bespock_content', function (Blueprint $table)
        {
            $table->dropColumn('navigation_id');
        });
    }
}
