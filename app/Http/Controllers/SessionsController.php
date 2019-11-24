<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // 使用 Request 实例来接收用户的所有输入数据
use Auth;

// 会话控制器类 用于处理用户登录退出相关的操作
class SessionsController extends Controller
{
    // 注册与登录页面访问限制
    public function __construct()
    {
        // 使用 Auth 中间件提供的 guest 选项，用于指定一些只允许未登录用户访问的动作
        $this->middleware('guest', ['only' => ['create']]);
    }
    // 显示登录页面
    public function create(){
        return view('sessions.create');
    }
    // 创建新会话（登录）
    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials, $request->has('remember'))) {
            // 登录成功后的相关操作
            session()->flash('success', '欢迎回来！');
            $fallback = route('users.show', [Auth::user()]);
            // 友好的转向 使用 intended 方法
            return redirect()->intended($fallback);
        }
        else {
            // 登录失败后的相关操作
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }
    }
    // 销毁会话（退出登录）
    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }
}
