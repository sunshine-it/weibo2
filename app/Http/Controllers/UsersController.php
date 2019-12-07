<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Mail;

// 用户控制器类
class UsersController extends Controller
{
    // 权限系统 构造器方法，当一个类对象被创建之前该方法将会被调用
    public function __construct()
    {
        // middleware 方法接收两个参数，第一个为中间件的名称，第二个为要进行过滤的动作
        // 使用中间件来过滤未登录用户的 edit, update 动作
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index', 'confirmEmail']
        ]);
        // 只让未登录用户访问注册页面
        $this->middleware('guest', ['only' => ['create']]);
    }
    // 列出所有用户
    public function index()
    {
        $users = User::paginate(10);
        // 用户列表
        return view('users.index', compact('users'));
    }
    // 创建用户
    public function create() {
        return view('users.create');
    }
    // 显示用户
    public function show(User $user) {
        $statuses = $user->statuses()->orderBy('created_at', 'desc')->paginate(10);
        return view('users.show', compact('user', 'statuses'));
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
        // Auth::login($user);
        // 设置闪存提示信息
        // session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        // 跳转到用户列表
        // return redirect()->route('users.show', [$user]);
        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect('/');
    }
    // 编辑表单
    public function edit(User $user)
    {
        // 授权策略 authorize 方法接收两个参数，第一个为授权策略的名称，第二个为进行授权验证的数据
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }
    // 更新表单
    public function update(User $user, Request $request)
    {
        // 授权策略 authorize 方法接收两个参数，第一个为授权策略的名称，第二个为进行授权验证的数据
        $this->authorize('update', $user);
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
    // 删除用户
    public function destroy(User $user)
    {
        // 授权策略，只允许已登录的 管理员 进行删除操作。
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '成功删除用户！');
        return back();
    }

    // 注册时发送邮件
    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        // $from = 'admin@example.com';
        // $name = '超级管理员';
        $to = $user->email;
        $subject = "感谢注册 Weibo2 应用！请确认你的邮箱。";
        // Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
        //     $message->from($from, $name)->to($to)->subject($subject);
        // });
        Mail::send($view, $data, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });
    }

    // 激活功能
    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', '恭喜你，激活成功！');
        return redirect()->route('users.show', [$user]);
    }
}
