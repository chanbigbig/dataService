<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusConfigTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('status_config', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('name', 30)->comment('状态昵称');
            $table->unsignedInteger('staff_id')->default(0)->comment('执行操作的员工id');
            $table->unsignedInteger('entity_id')->default(0)->comment('执行操作的单位id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_config');
    }
}
