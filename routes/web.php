<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\RegistrarController;

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

Route::get('/storage', function () {
    Artisan::call('storage:link');
});

Route::group(['middleware' => 'guest'], function () {
	Route::get('/', [LoginController::class, 'login'])->name('login');
	Route::get('/login', [LoginController::class, 'login'])->name('login');
	Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('login.authenticate');

    Route::get('/register', [RegisterController::class, 'register'])->name('register');
});

Route::group(['middleware' => 'auth'], function () {

	Route::group(['middleware' => 'admin'], function () {
		Route::group(['prefix' => 'admin'], function () {
			Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
			Route::get('/instructors', [AdminController::class, 'instructors'])->name('admin.instructors');
			Route::get('/courses', [AdminController::class, 'courses'])->name('admin.courses');
			Route::get('/courses-info/{id}', [AdminController::class, 'coursesInfo'])->name('admin.courses-info');
			Route::get('/schedule', [AdminController::class, 'schedule'])->name('admin.schedule');
			Route::get('/create-schedule/{id}', [AdminController::class, 'createSchedule'])->name('admin.create-schedule');
		});
	});

	Route::group(['middleware' => 'registrar'], function () {
		Route::group(['prefix' => 'registrar'], function () {
			Route::get('/dashboard', [RegistrarController::class, 'dashboard'])->name('registrar.dashboard');
			Route::get('/unscheduled', [RegistrarController::class, 'unscheduled'])->name('registrar.unscheduled');
			Route::get('/exam', [RegistrarController::class, 'exam'])->name('registrar.exam');
			Route::get('/interview', [RegistrarController::class, 'interview'])->name('registrar.interview');
			Route::get('/final-result', [RegistrarController::class, 'finalResult'])->name('registrar.final-result');
			Route::get('/enroll-grades', [RegistrarController::class, 'enrollGrades'])->name('registrar.enroll-grades');
			Route::get('/graduates', [RegistrarController::class, 'graduates'])->name('registrar.graduates');
			Route::get('/view-graduates/{id}', [RegistrarController::class, 'viewGraduates'])->name('registrar.view-graduates');
			Route::post('/registration-form', [RegistrarController::class, 'registrationForm'])->name('registrar.registrationform');
			Route::get('/enrollment/{id}', [RegistrarController::class, 'enrollment'])->name('registrar.enrollment');
			Route::get('/grades/{id}', [RegistrarController::class, 'grades'])->name('registrar.grades');
			Route::get('/edit-grades/{id}', [RegistrarController::class, 'editGrades'])->name('registrar.edit-grades');

		});
	});

	Route::group(['middleware' => 'trainer'], function () {
		Route::group(['prefix' => 'trainer'], function () {

		});
	});

	Route::group(['middleware' => 'student'], function () {
		Route::group(['prefix' => 'student'], function () {
			Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
			Route::get('/schedule', [StudentController::class, 'schedule'])->name('student.schedule');
			Route::get('/grades', [StudentController::class, 'grades'])->name('student.grades');
			Route::get('/registration-form', [StudentController::class, 'registrationForm'])->name('student.registrationform');
			Route::get('/proceed-enrollment', [StudentController::class, 'proceedEnrollment'])->name('student.proceed-enrollment');
		});
	});
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});