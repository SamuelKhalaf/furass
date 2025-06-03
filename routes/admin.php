<?php

use App\Enums\PermissionEnum;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\PermissionsController;
use App\Http\Controllers\admin\RolesController;
use App\Http\Controllers\admin\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware(['auth','verified'])->name('admin.')->group(function () {

    // View Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('permission:'. PermissionEnum::VIEW_DASHBOARD->value)
        ->name('dashboard');
    ############################### Start:Users Routes #####################################
    Route::middleware('permission:'. PermissionEnum::LIST_USERS->value)->group(function () {
        Route::get('users', [UsersController::class, 'index'])->name('users.index');
        Route::get('/user/all', [UsersController::class, 'getUsersDatatable'])->name('users.datatable');
    });

    Route::post('users', [UsersController::class, 'store'])
        ->middleware('permission:'. PermissionEnum::CREATE_USERS->value)
        ->name('users.store');

    Route::middleware('permission:'. PermissionEnum::UPDATE_USERS->value)->group(function () {
        Route::get('users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
        Route::put('users/{user}', [UsersController::class, 'update'])->name('users.update');
    });

    Route::delete('users/{user}', [UsersController::class, 'destroy'])
        ->middleware('permission:'. PermissionEnum::DELETE_USERS->value)
        ->name('users.destroy');
    ###############################  End:Users Routes  #####################################

    ############################### Start:Roles Routes #####################################
    Route::get('/roles', [RolesController::class, 'index'])
        ->middleware('permission:'.PermissionEnum::LIST_ROLES->value)
        ->name('roles.index');

    Route::post('/roles', [RolesController::class, 'store'])
        ->name('roles.store')
        ->middleware('permission:'.PermissionEnum::CREATE_ROLES->value);

    Route::middleware('permission:'. PermissionEnum::VIEW_ROLES->value)->group(function () {
        Route::get('/roles/{role}', [RolesController::class, 'show'])->name('roles.show');
        Route::get('/roles/{id}/users', [RolesController::class, 'getSpecificRoleUsersData'])->name('admin.roles.users');
    });

    Route::middleware('permission:'. PermissionEnum::UPDATE_ROLES->value)->group(function () {
        Route::get('/roles/{role}/edit', [RolesController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{role}', [RolesController::class, 'update'])->name('roles.update');
    });

    Route::middleware('permission:'. PermissionEnum::DELETE_ROLES->value)->group(function () {
        Route::delete('/roles/{role}', [RolesController::class, 'destroy'])->name('roles.destroy');
        Route::delete('/roles/{role}/users/{user}', [RolesController::class, 'deleteUsersAssignedToRole']);
    });
    ###############################  End:Roles Routes  #####################################

    ############################### Start:Permissions Routes #####################################
    Route::middleware('permission:'. PermissionEnum::LIST_PERMISSIONS->value)->group(function () {
        Route::get('/permissions', [PermissionsController::class, 'index'])->name('permissions.index');
        Route::get('/permissions-data', [PermissionsController::class, 'getPermissionsDatatable'])->name('permissions.data');
    });

    Route::post('/permissions', [PermissionsController::class, 'store'])
        ->middleware('permission:'.PermissionEnum::CREATE_PERMISSIONS->value)
        ->name('permissions.store');

    Route::delete('/permissions/{permission}', [PermissionsController::class, 'destroy'])
        ->middleware('permission:'.PermissionEnum::DELETE_PERMISSIONS->value)
        ->name('permissions.destroy');
    ###############################  End:Permissions Routes  #####################################
});
