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
        }); 

        Route::group(['prefix' => 'update'], function () {
            Route::patch('/course', [AdminController::class, 'updateCourse']);
        });
        
        Route::group(['prefix' => 'delete'], function () {
            Route::delete('/course', [AdminController::class, 'deleteCourse']);
        });

    });

    Route::group(['middleware' => 'registrar'], function () {
        
        Route::group(['prefix' => 'create'], function () {
        }); 

        Route::group(['prefix' => 'update'], function () { 
            Route::patch('/exam-schedule', [RegistrarController::class, 'updateExamSchedule']);
            Route::patch('/proceed-to-interview', [RegistrarController::class, 'updateProceedToInterview']);
            Route::patch('/proceed-to-final-result', [RegistrarController::class, 'updateProceedToFinalResult']);
            Route::patch('/admission-passed', [RegistrarController::class, 'updateAdmissionPassed']);
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
