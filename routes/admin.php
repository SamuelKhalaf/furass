<?php

use App\Enums\PermissionEnum;
use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\Admin\CategoryOfExamController;
use App\Http\Controllers\Admin\ConsultantController;
use App\Http\Controllers\Admin\ConsultationController;
use App\Http\Controllers\Admin\ConsultationNotesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\ProgramsController;
use App\Http\Controllers\Admin\QuestionBankTypeController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TripsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\ValuesQuestionsController;
use App\Http\Controllers\Admin\WorkshopsController;
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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
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

    ############################### Start:Consultants Routes #####################################
    Route::middleware('permission:'. PermissionEnum::LIST_CONSULTANTS->value)->group(function () {
        Route::get('consultants', [ConsultantController::class, 'index'])->name('consultants.index');
        Route::get('consultants/all', [ConsultantController::class, 'getConsultantsData'])->name('consultants.datatable');
    });

    Route::middleware('permission:'. PermissionEnum::CREATE_CONSULTANTS->value)->group(function () {
        Route::get('consultants/create', [ConsultantController::class, 'create'])->name('consultants.create');
        Route::post('consultants', [ConsultantController::class, 'store'])->name('consultants.store');
    });

    Route::middleware('permission:'. PermissionEnum::UPDATE_CONSULTANTS->value)->group(function () {
        Route::get('consultants/{consultant}/edit', [ConsultantController::class, 'edit'])->name('consultants.edit');
        Route::put('consultants/{consultant}', [ConsultantController::class, 'update'])->name('consultants.update');
    });

    Route::delete('consultants/{consultant}', [ConsultantController::class, 'destroy'])
        ->middleware('permission:'. PermissionEnum::DELETE_CONSULTANTS->value)
        ->name('consultants.destroy');
    ###############################  End:Consultants Routes  #####################################

    ############################### Start:Trips Routes #####################################
    Route::middleware('permission:'. PermissionEnum::LIST_TRIPS->value)->group(function () {
        Route::get('trips', [TripsController::class, 'index'])->name('trips.index');
        Route::get('trips/all', [TripsController::class, 'getTripsData'])->name('trips.datatable');
    });

    Route::middleware('permission:'. PermissionEnum::CREATE_TRIPS->value)->group(function () {
        Route::get('trips/create', [TripsController::class, 'create'])->name('trips.create');
        Route::post('trips', [TripsController::class, 'store'])->name('trips.store');
    });

    Route::middleware('permission:'. PermissionEnum::UPDATE_TRIPS->value)->group(function () {
        Route::get('trips/{trip}/edit', [TripsController::class, 'edit'])->name('trips.edit');
        Route::put('trips/{trip}', [TripsController::class, 'update'])->name('trips.update');
    });

    Route::delete('trips/{trip}', [TripsController::class, 'destroy'])
        ->middleware('permission:'. PermissionEnum::DELETE_TRIPS->value)
        ->name('trips.destroy');
    ###############################  End:Trips Routes  #####################################

    ############################### Start:Workshops Routes #####################################
    Route::middleware('permission:'. PermissionEnum::LIST_WORKSHOPS->value)->group(function () {
        Route::get('workshops', [WorkshopsController::class, 'index'])->name('workshops.index');
        Route::get('workshops/all', [WorkshopsController::class, 'getWorkshopsData'])->name('workshops.datatable');
    });

    Route::middleware('permission:'. PermissionEnum::CREATE_WORKSHOPS->value)->group(function () {
        Route::get('workshops/create', [WorkshopsController::class, 'create'])->name('workshops.create');
        Route::post('workshops', [WorkshopsController::class, 'store'])->name('workshops.store');
    });

    Route::middleware('permission:'. PermissionEnum::UPDATE_WORKSHOPS->value)->group(function () {
        Route::get('workshops/{workshop}/edit', [WorkshopsController::class, 'edit'])->name('workshops.edit');
        Route::put('workshops/{workshop}', [WorkshopsController::class, 'update'])->name('workshops.update');
    });

    Route::delete('workshops/{workshop}', [WorkshopsController::class, 'destroy'])
        ->middleware('permission:'. PermissionEnum::DELETE_WORKSHOPS->value)
        ->name('workshops.destroy');
    ###############################  End:Workshops Routes  #####################################

    ############################### Start:Programs Routes #####################################
    Route::middleware('permission:'. PermissionEnum::LIST_PROGRAMS->value)->group(function () {
        Route::get('programs', [ProgramsController::class, 'index'])->name('programs.index');
        Route::get('programs/all', [ProgramsController::class, 'getProgramsData'])->name('programs.datatable');
    });

    Route::middleware('permission:'. PermissionEnum::UPDATE_PROGRAMS->value)->group(function () {
        Route::get('programs/{program}/edit', [ProgramsController::class, 'edit'])->name('programs.edit');
        Route::put('programs/{program}', [ProgramsController::class, 'update'])->name('programs.update');
    });
    ###############################  End:Programs Routes  #####################################

    ############################### Start:Calendar Routes #####################################
    Route::middleware('permission:'. PermissionEnum::LIST_EVENTS->value)->group(function () {
        Route::get('calendar', [CalendarController::class, 'index'])->name('calendar.index');
        Route::get('calendar/all', [CalendarController::class, 'getCalendarData'])->name('calendar.datatable');
    });

    Route::middleware('permission:'. PermissionEnum::CREATE_EVENTS->value)->group(function () {
        Route::post('calendar', [CalendarController::class, 'store'])->name('calendar.store');
    });

    Route::middleware('permission:'. PermissionEnum::UPDATE_EVENTS->value)->group(function () {
        Route::get('calendar/{calendar}/edit', [CalendarController::class, 'edit'])->name('calendar.edit');
        Route::put('calendar/{calendar}', [CalendarController::class, 'update'])->name('calendar.update');
    });

    Route::delete('calendar/{calendar}', [CalendarController::class, 'destroy'])
        ->middleware('permission:'. PermissionEnum::DELETE_EVENTS->value)
        ->name('calendar.destroy');
    ###############################  End:Calendar Routes  #####################################

    ############################### Start:News Routes #####################################
    Route::middleware('permission:'. PermissionEnum::LIST_NEWS->value)->group(function () {
        Route::get('news', [NewsController::class, 'index'])->name('news.index');
        Route::get('news/all', [NewsController::class, 'getNewsData'])->name('news.datatable');
    });

    Route::middleware('permission:'. PermissionEnum::CREATE_NEWS->value)->group(function () {
        Route::post('news', [NewsController::class, 'store'])->name('news.store');
    });

    Route::middleware('permission:'. PermissionEnum::UPDATE_NEWS->value)->group(function () {
        Route::get('news/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');
        Route::put('news/{news}', [NewsController::class, 'update'])->name('news.update');
    });

    Route::delete('news/{news}', [NewsController::class, 'destroy'])
        ->middleware('permission:'. PermissionEnum::DELETE_NEWS->value)
        ->name('news.destroy');
    ###############################  End:News Routes  #####################################

    ##############################  Start:Notifications Routes  ####################################
    Route::middleware('auth')->group(function() {
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/users/search', [NotificationController::class, 'searchUsers'])->name('users.search');
        Route::post('/notifications/store', [NotificationController::class, 'store'])->name('notifications.store');
        Route::get('/notifications/get', [NotificationController::class, 'getSomeNotifications']);
        Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
        Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
        Route::get('/notifications/all', [NotificationController::class, 'allNotifications'])->name('notifications.all');
        Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show');
    });
    ###############################  End:Notifications Routes  #####################################

    ############################### Start:Consultations Routes #####################################
//    Route::middleware('permission:'. PermissionEnum::LIST_CONSULTANTS->value)->group(function () {
//        Route::get('consultations', [ConsultationController::class, 'index'])->name('consultations.index');
//        Route::get('consultations/all', [ConsultationController::class, 'getConsultationsData'])->name('consultations.datatable');
//    });
//
//    Route::post('consultations', [ConsultationController::class, 'store'])
//        ->middleware('permission:'. PermissionEnum::CREATE_CONSULTANTS->value)
//        ->name('consultations.store');
//
//    Route::middleware('permission:'. PermissionEnum::UPDATE_CONSULTANTS->value)->group(function () {
//        Route::get('consultations/{consultant}/edit', [ConsultationController::class, 'edit'])->name('consultations.edit');
//        Route::put('consultations/{consultant}', [ConsultationController::class, 'update'])->name('consultations.update');
//    });
//
//    Route::delete('consultations/{consultant}', [ConsultationController::class, 'destroy'])
//        ->middleware('permission:'. PermissionEnum::DELETE_CONSULTANTS->value)
//        ->name('consultations.destroy');
    ###############################  End:Consultations Routes  #####################################

    ##############################  start:CatExams Routes  ####################################
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

    ###############################  start:question bank Routes  #####################################
    Route::middleware('permission:'. PermissionEnum::LIST_SCHOOLS->value)->group(function () {
        Route::get('question-bank', [QuestionBankTypeController::class, 'index'])->name('QuestionBank.index');
        Route::get('question-bank/all', [QuestionBankTypeController::class, 'getQuestionBankData'])->name('QuestionBank.datatable');
    });

    Route::post('question-bank-store', [QuestionBankTypeController::class, 'store'])
        ->middleware('permission:'. PermissionEnum::CREATE_SCHOOLS->value)
        ->name('questionBank.store');

    Route::middleware('permission:'. PermissionEnum::UPDATE_SCHOOLS->value)->group(function () {
        Route::get('questionBank/{questionBank}/edit', [QuestionBankTypeController::class, 'edit'])->name('questionBank.edit');
        Route::put('questionBank/{questionBank}', [QuestionBankTypeController::class, 'update'])->name('questionBank.update');
    });

    Route::delete('questionBank/{questionBank}', [QuestionBankTypeController::class, 'destroy'])
        ->middleware('permission:'. PermissionEnum::DELETE_SCHOOLS->value)
        ->name('questionBank.destroy');
    ###############################  End:question bank Routes  #####################################

    ###############################  start:value question Routes  #####################################
    Route::middleware('permission:'. PermissionEnum::LIST_SCHOOLS->value)->group(function () {
        Route::get('value-question', [ValuesQuestionsController::class, 'index'])->name('valueQuestion.index');
        Route::get('value-question/all', [ValuesQuestionsController::class, 'getValueQuestionData'])->name('valueQuestion.datatable');
    });

    Route::get('value-question-store', [ValuesQuestionsController::class, 'getDataForCreate'])
        ->middleware('permission:'. PermissionEnum::CREATE_SCHOOLS->value)
        ->name('valueQuestion.getData.store');

    Route::post('value-question-store-post', [ValuesQuestionsController::class, 'store'])
        ->middleware('permission:'. PermissionEnum::CREATE_SCHOOLS->value)
        ->name('questionValue.store');

    Route::middleware('permission:'. PermissionEnum::UPDATE_SCHOOLS->value)->group(function () {
        Route::get('value-question/{value}/edit', [ValuesQuestionsController::class, 'edit'])->name('questionValue.edit');
        Route::put('value-question/{value}', [ValuesQuestionsController::class, 'update'])->name('questionValue.update');
    });

    Route::delete('value-question/{value}', [ValuesQuestionsController::class, 'destroy'])
        ->middleware('permission:'. PermissionEnum::DELETE_SCHOOLS->value)
        ->name('questionValue.destroy');
    ###############################  End:value question Routes  #####################################

    ###############################  start:pages Routes  #####################################
    Route::middleware('permission:'. PermissionEnum::LIST_PAGES->value)->group(function () {
        Route::get('pages', [PagesController::class, 'index'])->name('pages.index');
        Route::get('pages/all', [PagesController::class, 'getPagesData'])->name('pages.datatable');
    });

    Route::post('page-store', [PagesController::class, 'store'])
        ->middleware('permission:'. PermissionEnum::CREATE_PAGES->value)
        ->name('page.store');

    Route::post('/ckeditor/upload', [PagesController::class, 'uploadImage'])->name('ckeditor.upload');


    Route::middleware('permission:'. PermissionEnum::UPDATE_PAGES->value)->group(function () {
        Route::get('page/{value}/edit', [PagesController::class, 'edit'])->name('pages.edit');
        Route::put('page/{value}', [PagesController::class, 'update'])->name('pages.update');
    });

    Route::delete('page/{value}', [PagesController::class, 'destroy'])
        ->middleware('permission:'. PermissionEnum::DELETE_PAGES->value)
        ->name('page.destroy');
    ###############################  End:pages question Routes  #####################################
});
