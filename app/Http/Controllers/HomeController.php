<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('login');
    }
}
