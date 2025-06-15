<?php

use App\Enums\PermissionEnum;
use App\Http\Controllers\Admin\CategoryOfExamController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\SchoolController;
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
Route::middleware(['auth'])->name('admin.')->group(function () {

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
    ##############################  Start:Students Routes  ####################################
    Route::middleware('permission:'. PermissionEnum::LIST_STUDENTS->value)->group(function () {
        Route::get('students', [StudentController::class, 'index'])->name('students.index');
        Route::get('/students/all', [StudentController::class, 'getStudentsData'])->name('students.datatable');
    });

    Route::post('students', [StudentController::class, 'store'])
        ->middleware('permission:'. PermissionEnum::CREATE_STUDENTS->value)
        ->name('students.store');

    Route::middleware('permission:'. PermissionEnum::UPDATE_STUDENTS->value)->group(function () {
        Route::get('students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
        Route::put('students/{student}', [StudentController::class, 'update'])->name('students.update');
    });

    Route::delete('students/{student}', [StudentController::class, 'destroy'])
        ->middleware('permission:'. PermissionEnum::DELETE_STUDENTS->value)
        ->name('students.destroy');
    ###############################  End:Students Routes  #####################################

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

    ############################### Start:Schools Routes #####################################
    Route::middleware('permission:'. PermissionEnum::LIST_SCHOOLS->value)->group(function () {
        Route::get('schools', [SchoolController::class, 'index'])->name('schools.index');
        Route::get('schools/all', [SchoolController::class, 'getSchoolsData'])->name('schools.datatable');
    });

    Route::post('schools', [SchoolController::class, 'store'])
        ->middleware('permission:'. PermissionEnum::CREATE_SCHOOLS->value)
        ->name('schools.store');

    Route::middleware('permission:'. PermissionEnum::UPDATE_SCHOOLS->value)->group(function () {
        Route::get('schools/{school}/edit', [SchoolController::class, 'edit'])->name('schools.edit');
        Route::put('schools/{school}', [SchoolController::class, 'update'])->name('schools.update');
    });

    Route::delete('schools/{school}', [SchoolController::class, 'destroy'])
        ->middleware('permission:'. PermissionEnum::DELETE_SCHOOLS->value)
        ->name('schools.destroy');
    ###############################  End:Schools Routes  #####################################

    ###############################  start:CatExams Routes  #####################################
    Route::middleware('permission:'. PermissionEnum::LIST_SCHOOLS->value)->group(function () {
        Route::get('category-of-exam', [CategoryOfExamController::class, 'index'])->name('category.index');
        Route::get('categories/all', [CategoryOfExamController::class, 'getCategoryData'])->name('category.datatable');
    });

    Route::post('category-of-exam', [CategoryOfExamController::class, 'store'])
        ->middleware('permission:'. PermissionEnum::CREATE_SCHOOLS->value)
        ->name('category.store');

    Route::middleware('permission:'. PermissionEnum::UPDATE_SCHOOLS->value)->group(function () {
        Route::get('categories/{school}/edit', [CategoryOfExamController::class, 'edit'])->name('categories.edit');
        Route::put('categories/{school}', [CategoryOfExamController::class, 'update'])->name('categories.update');
    });

    Route::delete('category/{category}', [CategoryOfExamController::class, 'destroy'])
        ->middleware('permission:'. PermissionEnum::DELETE_SCHOOLS->value)
        ->name('category.destroy');
    ###############################  End:CatExams Routes  #####################################

    Route::get('landing-page', function (){
        return view('landing-page');
    });


});
