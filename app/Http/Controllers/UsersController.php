<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// 用户控制器类
class UsersController extends Controller
{
    public function create() {
        return view('users.create');
    }
}
