<?php

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Http\Controllers\Admin\SchoolController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\LanguageController;

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

Route::get('/test', function () {
    $adminRole = Role::firstOrCreate(['name' => RoleEnum::ADMIN->value]);
    $adminRole->givePermissionTo(PermissionEnum::all());
});

Route::post('request-school', [SchoolController::class, 'store'])->name('request-school.store');

Route::get('language/{locale}', [LanguageController::class, 'switchLang'])->name('language.switch');

Route::get('home', function (){
    return view('template.home');
})->name('template.home');

Route::get('about', function (){
    return view('template.about');
})->name('template.about');

Route::get('our-programs', function (){
    return view('template.programs');
})->name('template.programs');

Route::get('contact', function (){
    return view('template.contact');
})->name('template.contact');

Route::get('request-school', function (){
    return view('template.request_school');
})->name('template.school');

Route::get('details-programs', function (){
    return view('template.details-programs');
})->name('template.details-programs');
