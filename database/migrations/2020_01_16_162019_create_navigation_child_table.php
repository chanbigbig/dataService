<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavigationChildTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navigation_child', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('navigation_id')->default(0)->index();
            $table->string('title')->default('')->comment('标题内容');
            $table->string('content')->default('')->comment('详情');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('navigation_child');
    }
}
