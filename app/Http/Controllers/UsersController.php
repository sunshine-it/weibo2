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
    // 显示用户
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
    // 编辑表单
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }
    // 更新表单
    public function update(User $user, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6' // nullable，这意味着当用户提供空白密码时也会通过验证
        ]);
        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        session()->flash('success', '个人资料更新成功！');
        return redirect()->route('users.show', $user->id);
    }
}
