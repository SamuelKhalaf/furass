<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole(RoleEnum::ADMIN->value)) {
            return app(AdminDashboardController::class)->index();
        }

        if ($user->hasRole(RoleEnum::STUDENT->value)) {
            return app(StudentDashboardController::class)->index();
        }

        if ($user->hasRole(RoleEnum::CONSULTANT->value)) {
            return app(ConsultantDashboardController::class)->index();
        }

        if ($user->hasRole(RoleEnum::SCHOOL->value)) {
            return app(SchoolDashboardController::class)->index();
        }

        return view('admin.dashboards.default');
    }
}
