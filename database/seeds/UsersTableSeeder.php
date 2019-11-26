<?php

use Illuminate\Database\Seeder;
use App\Models\User;

// 用于填充用户相关的假数据
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(50)->make();
        User::insert($users->makeVisible(['password', 'remember_token'])->toArray());

        $user = User::find(1);
        $user->name = '超级管理员';
        $user->email = 'admin@example.com';
        $user->is_admin = true; // 设置为管理员
        $user->save();
    }
}
