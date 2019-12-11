<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Status;

// 微博控制器类
class StatusesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 处理创建微博的请求
    public function store(Request $request)
    {
        $this->validate($request, ['content' => 'required|max:140']);
        Auth::user()->statuses()->create(['content' => $request['content']]);
        session()->flash('success', '发布成功！');
        return redirect()->back();
    }
    // 处理删除微博的请求
    public function destroy(Status $status)
    {
        $this->authorize('destroy', $status);
        $status->delete();
        session()->flash('success', '微博已被成功删除！');
        return redirect()->back();
    }

}
