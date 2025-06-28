<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole(RoleEnum::ADMIN->value)) {
            return view('admin.dashboards.admin');
        } else {
            return view('admin.dashboards.default');
        }
    }
}
