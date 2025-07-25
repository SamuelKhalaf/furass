<?php

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Http\Controllers\Admin\SchoolController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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

//Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/test', function () {
    $adminRole = Role::firstOrCreate(['name' => RoleEnum::ADMIN->value]);
    $adminRole->givePermissionTo(PermissionEnum::all());
});

Route::post('request-school', [SchoolController::class, 'store'])->name('request-school.store');

Route::get('language/{locale}', [LanguageController::class, 'switchLang'])->name('language.switch');

Route::get('/', function (){
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

Route::get('template-questions', function (){
    return view('template.questions');
})->name('template.questions');

Route::get('template-news/{idNews?}', [\App\Http\Controllers\Admin\NewsController::class, 'displayNewsPage'])->name('template.news');
Route::get('template-page/{id}', [\App\Http\Controllers\Admin\PagesController::class, 'displayPagesInTemplate'])->name('template.pages');
