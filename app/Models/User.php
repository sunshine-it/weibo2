<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Auth;

// 用户模型
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // 生成令牌 boot 方法会在用户模型类完成初始化之后进行加载，因此我们对事件的监听需要放在该方法中
    public static function boot()
    {
        parent::boot();
        // 监听 creating 方法，用于监听模型被创建之前的事件
        static::creating(function ($user) {
            $user->activation_token = Str::random(10);
        });
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Gravatar 为 “全球通用头像”
    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }

    // 指明一个用户拥有多条微博 statuses
    public function statuses()
    {
        // 一对多关系
        return $this->hasMany(Status::class);
    }

    // 动态流原型
    public function feed()
    {
        // 在主页上显示所有关注用户的微博动态
        // return $this->statuses()->orderBy('created_at', 'desc');
        // 通过 followings 方法取出所有关注用户的信息，再借助 pluck 方法将 id 进行分离并赋值给 user_ids
        $user_ids = $this->followings->pluck('id')->toArray();
        // 将当前用户的 id 加入到 user_ids 数组中
        array_push($user_ids, $this->id);
        // dump($this->followings()->get());
        // 使用 Laravel 提供的 查询构造器 whereIn 方法取出所有用户的微博动态并进行倒序排序
        // 使用了 Eloquent 关联的 预加载 with 方法，预加载避免了 N+1 查找的问题，大大提高了查询效率
        return Status::whereIn('user_id', $user_ids)->with('user')->orderBy('created_at', 'desc');
    }

    // 关注的人和粉丝 通过 followers 来获取粉丝关系列表
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id'); // follower_id
    }
    // 通过 followings 来获取用户关注人列表
    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    // 定义关注
    public function follow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->sync($user_ids, false);
    }
    // 取消关注
    public function unfollow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->detach($user_ids);
    }
    // 判断当前登录的用户 A 是否关注了用户 B
    public function isFollowing($user_id)
    {
        return $this->followings->contains($user_id);
    }
}
