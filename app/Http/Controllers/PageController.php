<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('auth.login');
    }

    public function dashboard()
    {
        return view('kiosk');
    }
}
