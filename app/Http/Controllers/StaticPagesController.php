<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// 静态页面的控制器类
class StaticPagesController extends Controller
{
    public function home() {
        // return 'home';
        return view('static_pages/home');
    }
    public function help() {
        // return 'help';
        return view('static_pages/help');
    }
    public function about() {
        // return 'about';
        return view('static_pages/about');
    }
}
