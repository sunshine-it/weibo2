<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

// 用户控制器类
class UsersController extends Controller
{
    // 创建用户
    public function create() {
        return view('users.create');
    }
    // 用户列表
    public function show(User $user) {
        return view('users.show', compact('user'));
    }
    // 保存用户
    public function store(Request $request) {
        // 验证
        $this->validate($request, [
            'name'=>'required|max:50',
            'email'=>'required|email|unique:users|max:255',
            'password'=>'required|confirmed|min:6'
        ]);
        // 将用户提交且验证通过的数据保存进数据库
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);
        // 注册后自动登录
        Auth::login($user);
        // 设置闪存提示信息
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        // 跳转到用户列表
        return redirect()->route('users.show', [$user]);
    }
}
