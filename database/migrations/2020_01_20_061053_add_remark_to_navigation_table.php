<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRemarkToNavigationTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('navigation', function (Blueprint $table)
        {
            $table->string('des')->default('')->default('');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('navigation', function (Blueprint $table)
        {
            $table->dropColumn('des');
        });
    }
}
