<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsHistoryToCourseTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('course', function (Blueprint $table)
        {
            $table->unsignedTinyInteger('is_history')->comment('是否以往案例');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('course', function (Blueprint $table)
        {
            $table->dropColumn('is_history');
        });
    }
}
