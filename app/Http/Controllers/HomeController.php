<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function admin()
    {
        return view('admin.home');
    }

    public function editor()
    {
        return view('editor.home');
    }

    public function user()
    {
        return view('user.home');
    }

    public function index()
    {
        return view('home');
    }
}
