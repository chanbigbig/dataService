<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('status_config')->insert([

            [
                'name' => '工作人员已经接单，硬盘正在检测中',
                'entity_id' => 1,
                'staff_id' => 1,
            ],
            [
                'name' => '硬盘正在修复中',
                'entity_id' => 1,
                'staff_id' => 1,
            ],
            [
                'name' => '硬盘正在拷贝数据中',
                'entity_id' => 1,
                'staff_id' => 1,
            ],
            [
                'name' => '硬盘数据恢复完成，等待客户到门店取数据',
                'entity_id' => 1,
                'staff_id' => 1,
            ],
            [
                'name' => '客户已经成功获取数据，但未取回原硬盘',
                'entity_id' => 1,
                'staff_id' => 1,
            ],
            [
                'name' => '订单已完成，客户成功取回数据和硬盘',
                'entity_id' => 1,
                'staff_id' => 1,
            ],
            [
                'name' => '硬盘维修恢复数据终止，等待客户取回硬盘',
                'entity_id' => 1,
                'staff_id' => 1,
            ],
            [
                'name' => '订单硬盘交接完成，客户取回原硬盘',
                'entity_id' => 1,
                'staff_id' => 1,
            ]
        ]);
    }
}
