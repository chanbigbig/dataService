<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDataTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('order_id')->default('')->comment('编号ID');
            $table->date('order_date')->comment('下单日期');
            $table->string('customer_name', 128)->default('')->comment('客户昵称');
            $table->bigInteger('contact_handset')->nullable()->default(0)->comment('联系人手机');
            $table->string('contact_fixline', 32)->nullable()->default('')->comment('联系人固话');
            $table->string('remark', 256)->nullable()->default('')->comment('订单备注');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态');
            $table->date('finish_time')->comment('预计完成时间');
            $table->unsignedInteger('user_id')->default(0)->comment('执行操作的员工id');

            $table->index('order_id');
            $table->index('contact_handset');
            $table->index('contact_fixline');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_data');
    }
}
