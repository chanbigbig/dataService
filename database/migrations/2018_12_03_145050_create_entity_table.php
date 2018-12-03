<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entity', function (Blueprint $table)
        {
            $table->unsignedInteger('entity_id')->unique()->default(0)->comment('单位ID');
            $table->string('entity_name', 20)->default('')->comment('单位名');
            $table->string('project', 20)->default('yingxu')->comment('所属项目');

            $table->string('contact_name', 20)->default('')->comment('联系人');
            $table->bigInteger('contact_handset')->default(0)->comment('联系人手机');
            $table->string('address', 225)->default('')->comment('收货地址');
            $table->string('remarks', 225)->default('')->comment('备注');

            $table->primary('entity_id');

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
        Schema::dropIfExists('entity');
    }
}
