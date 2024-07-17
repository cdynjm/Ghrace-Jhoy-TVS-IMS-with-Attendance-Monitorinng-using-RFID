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
			Route::get('/trainers', [AdminController::class, 'trainers'])->name('admin.trainers');
			Route::get('/courses', [AdminController::class, 'courses'])->name('admin.courses');
			Route::get('/students', [AdminController::class, 'students'])->name('admin.students');
		});
	});

	Route::group(['middleware' => 'registrar'], function () {
		Route::group(['prefix' => 'registrar'], function () {
			Route::get('/dashboard', [RegistrarController::class, 'dashboard'])->name('registrar.dashboard');
			Route::get('/unscheduled', [RegistrarController::class, 'unscheduled'])->name('registrar.unscheduled');
			Route::get('/exam', [RegistrarController::class, 'exam'])->name('registrar.exam');
			Route::get('/interview', [RegistrarController::class, 'interview'])->name('registrar.interview');
			Route::get('/final-result', [RegistrarController::class, 'finalResult'])->name('registrar.final-result');
			Route::post('/registration-form', [RegistrarController::class, 'registrationForm'])->name('registrar.registrationform');
		});
	});

	Route::group(['middleware' => 'trainer'], function () {
		Route::group(['prefix' => 'trainer'], function () {

		});
	});

	Route::group(['middleware' => 'student'], function () {
		Route::group(['prefix' => 'student'], function () {
			Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
			Route::get('/registration-form', [StudentController::class, 'registrationForm'])->name('student.registrationform');
			Route::get('/proceed-enrollment', [StudentController::class, 'proceedEnrollment'])->name('student.proceed-enrollment');
		});
	});
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});