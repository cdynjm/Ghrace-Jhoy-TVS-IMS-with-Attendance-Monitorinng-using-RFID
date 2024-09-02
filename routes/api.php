<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\RegistrarController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/get-province', [RegisterController::class, 'Province']);
Route::post('/get-municipal', [RegisterController::class, 'Municipal']);
Route::post('/get-barangay', [RegisterController::class, 'Barangay']);

Route::post('/get-birthplace-province', [RegisterController::class, 'BirthplaceProvince']);
Route::post('/get-birthplace-municipal', [RegisterController::class, 'BirthplaceMunicipal']);

Route::post('/admission-application', [RegisterController::class, 'AdmissionApplication']);

Route::middleware('auth:sanctum')->group(function () {
    
    Route::group(['middleware' => 'admin'], function () {

        Route::group(['prefix' => 'create'], function () {
            Route::post('/course', [AdminController::class, 'createCourse']);
            Route::post('/course-info', [AdminController::class, 'createCourseInfo']);
            Route::post('/instructor', [AdminController::class, 'createInstructor']);
            Route::post('/schedule', [AdminController::class, 'createSubjectSchedule']);
            Route::post('/subjects', [AdminController::class, 'getSubjects']);
            Route::post('/subject-schedule', [AdminController::class, 'getSubjectSchedule']);
        }); 

        Route::group(['prefix' => 'update'], function () {
            Route::patch('/course', [AdminController::class, 'updateCourse']);
            Route::patch('/instructor', [AdminController::class, 'updateInstructor']);
            Route::patch('/schedule', [AdminController::class, 'updateSubjectSchedule']);
            Route::patch('/admin/admission-status', [AdminController::class, 'admissionStatus']);
        });
        
        Route::group(['prefix' => 'delete'], function () {
            Route::delete('/course', [AdminController::class, 'deleteCourse']);
            Route::delete('/instructor', [AdminController::class, 'deleteInstructor']);
            Route::delete('/schedule', [AdminController::class, 'archiveSubjectSchedule']);
        });

    });

    Route::group(['middleware' => 'registrar'], function () {
        
        Route::group(['prefix' => 'create'], function () {
        }); 

        Route::group(['prefix' => 'update'], function () { 
            Route::patch('/exam-schedule', [RegistrarController::class, 'updateExamSchedule']);
            Route::patch('/proceed-to-interview', [RegistrarController::class, 'updateProceedToInterview']);
            Route::patch('/proceed-to-second-interview', [RegistrarController::class, 'updateProceedToSecondInterview']);
            Route::patch('/proceed-to-final-result', [RegistrarController::class, 'updateProceedToFinalResult']);
            Route::patch('/admission-passed', [RegistrarController::class, 'updateAdmissionPassed']);
            Route::patch('/enroll-student', [RegistrarController::class, 'enrollStudent']);
            Route::patch('/grades', [RegistrarController::class, 'updateGrades']);

            Route::patch('/failed-exam', [RegistrarController::class, 'failedExam']);
            Route::patch('/failed-interview', [RegistrarController::class, 'failedInterview']);
            Route::patch('/failed-admission', [RegistrarController::class, 'failedAdmission']);

            Route::patch('/registrar/admission-status', [RegistrarController::class, 'admissionStatus']);
        });
        
        Route::group(['prefix' => 'delete'], function () {
        });

    });

    Route::group(['middleware' => 'trainer'], function () {
        
        Route::group(['prefix' => 'create'], function () {
        }); 

        Route::group(['prefix' => 'update'], function () {
        });
        
        Route::group(['prefix' => 'delete'], function () {
        });

    });

    Route::group(['middleware' => 'student'], function () {
        
        Route::group(['prefix' => 'create'], function () {
            Route::post('/upload-psa', [StudentController::class, 'uploadPSA']);
            Route::post('/upload-form137', [StudentController::class, 'uploadForm137']);
        }); 

        Route::group(['prefix' => 'update'], function () {
            Route::patch('/proceed-review', [StudentController::class, 'proceedReview']);
        });
        
        Route::group(['prefix' => 'delete'], function () {
            Route::delete('/psa', [StudentController::class, 'deletePSA']);
            Route::delete('/form137', [StudentController::class, 'deleteForm137']);
        });

    });
});
