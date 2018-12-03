<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDataLineTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('order_data_line', function (Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('order_data_id')->default(0)->comment('订单ID');
            $table->string('name', 128)->default('')->comment('硬盘描述');
            $table->string('size', 10)->default('')->comment('硬盘容量');
            $table->unsignedTinyInteger('num')->default(1)->comment('数量');
            $table->string('remark', 128)->default('')->comment('备注');
            $table->unsignedInteger('staff_id')->default(0)->comment('执行操作的员工id');
            $table->unsignedInteger('entity_id')->default(0)->comment('执行操作的单位id');
            $table->index('order_data_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_data_line');
    }
}
