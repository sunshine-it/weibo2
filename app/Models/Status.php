<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// 微博模型
class Status extends Model
{
    // 微博模型的 fillable 属性中允许更新微博的 content 字段即可
    protected $fillable = ['content'];
    // 指明一条微博属于一个用户
    public function user()
    {
        // 一对一关系
        return $this->belongsTo(User::class);
    }
}
