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
        $user->name = '汤姆';
        $user->email = 'tom@example.com';
        $user->save();
    }
}
