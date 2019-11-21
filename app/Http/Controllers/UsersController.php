<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

// 用户控制器类
class UsersController extends Controller
{
    public function create() {
        return view('users.create');
    }

    public function show(User $user) {
        return view('users.show', compact('user'));
    }
}
