<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSummaryToCourseTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('course', function (Blueprint $table)
        {
            $table->string('summary', 256)->comment('摘要');
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
            $table->string('summary');
        });
    }
}
