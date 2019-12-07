<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// 微博模型
class Status extends Model
{
    // 指明一条微博属于一个用户
    public function user()
    {
        // 一对一关系
        return $this->belongsTo(User::class);
    }
}
