<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
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
