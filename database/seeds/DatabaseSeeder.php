<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

// 用于注册种子类
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();
        // 指定调用用户数据填充文件
        $this->call(UsersTableSeeder::class);
        // 指定调用微博数据填充文件
        $this->call(StatusesTableSeeder::class);
        // 指定调用用户关注粉丝数据填充文件
        $this->call(FollowersTableSeeder::class);
        Model::reguard();
    }
}
