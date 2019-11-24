<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

// 用户策略
class UserPolicy
{
    use HandlesAuthorization;
    // update 方法接收两个参数，第一个参数默认为当前登录用户实例，第二个参数则为要进行授权的用户实例
    public function update(User $currentUser, User $user)
    {
        // 用户只能编辑自己的资料
        return $currentUser->id === $user->id;
    }

}
