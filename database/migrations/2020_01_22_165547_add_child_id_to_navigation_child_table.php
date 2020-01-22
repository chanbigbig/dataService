<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChildIdToNavigationChildTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('navigation_child', function (Blueprint $table)
        {
            $table->string('child_table')->comment('关联表名称');
            $table->unsignedInteger('child_id')->comment('素材关联ID');
            $table->index(['child_table', 'child_id']);
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('navigation_child', function (Blueprint $table)
        {
            $table->dropColumn('child_table');
            $table->dropColumn('child_id');
        });
    }
}
