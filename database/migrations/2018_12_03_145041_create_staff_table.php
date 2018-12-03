<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->unsignedInteger('staff_id')->unique()->default(0)->comment('员工ID');
            $table->string('account', 20)->index('account')->default('')->comment('登录帐号');
            $table->string('staff_name', 20)->default('')->comment('员工名');
            $table->string('project', 20)->default('yingxu')->comment('所属项目');
            $table->string('staff_type', 20)->default('')->comment('员工类型');
            $table->string('staff_level', 20)->default('')->comment('员工级别');
            $table->string('staff_custom_type', 20)->default('')->comment('自定义员工类型');
            $table->unsignedInteger('entity_id')->default(0)->index('entity_id')->comment('单位ID');
            $table->unsignedInteger('valid_flag')->default(0)->comment('是否有效');
            $table->string('token', 500)->default('')->comment('OA登录token');

            $table->primary('staff_id');

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
        Schema::dropIfExists('staff');
    }
}
