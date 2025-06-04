<?php

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes(['register' => false,'verify' => false]);

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/401', function () {
    abort(401);
});
Route::get('/500', function () {
    abort(500);
});

Route::get('/test', function () {
    $adminRole = Role::firstOrCreate(['name' => RoleEnum::ADMIN->value]);
    $adminRole->givePermissionTo(PermissionEnum::all());
});
