<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Status;

// 微博的授权策略
class StatusPolicy
{
    use HandlesAuthorization;

    public function destroy(User $user, Status $status)
    {
        // 当前用户的 id 与要删除的微博作者 id 相同时，验证才能通过
        return $user->id === $status->user_id;
    }
}
