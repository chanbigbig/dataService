<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvisesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('advises', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('name')->default('')->comment('名字');
            $table->string('email')->default('')->comment('邮件');
            $table->text('content')->comment('内容');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advises');
    }
}
