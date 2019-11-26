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
    // 删除用户的动作，有两个逻辑需要提前考虑：
    // 只有当前登录用户为管理员才能执行删除操作；
    // 删除的用户对象不是自己（即使是管理员也不能自己删自己）
    public function destroy(User $currentUser, User $user)
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }

}
