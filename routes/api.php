<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\RegistrarController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrainerController;

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
    
    Route::post('/update-profile', [ProfileController::class, 'updateProfile']);

    Route::group(['middleware' => 'AdminOrRegistrar'], function () {
        
        Route::group(['prefix' => 'log'], function () {
            Route::post('/attendance', [AttendanceController::class, 'LogRFIDAttendance']);
        }); 
    });

    Route::group(['middleware' => 'admin'], function () {

        Route::group(['prefix' => 'create'], function () {
            Route::post('/course', [AdminController::class, 'createCourse']);
            Route::post('/course-info', [AdminController::class, 'createCourseInfo']);
            Route::post('/admin/instructor', [AdminController::class, 'createInstructor']);
            Route::post('/schedule', [AdminController::class, 'createSubjectSchedule']);
            Route::post('/subjects', [AdminController::class, 'getSubjects']);
            Route::post('/subject-schedule', [AdminController::class, 'getSubjectSchedule']);
            Route::post('/course-info-subject', [AdminController::class, 'getCourseInfoSubject']);
        }); 

        Route::group(['prefix' => 'update'], function () {
            Route::patch('/course', [AdminController::class, 'updateCourse']);
            Route::patch('/admin/instructor', [AdminController::class, 'updateInstructor']);
            Route::patch('/schedule', [AdminController::class, 'updateSubjectSchedule']);
            Route::patch('/admin/admission-status', [AdminController::class, 'admissionStatus']);
            Route::patch('/course-info', [AdminController::class, 'updateCourseInfo']);
            Route::patch('/sms-token', [AdminController::class, 'updateSMSToken']);
        });
        
        Route::group(['prefix' => 'delete'], function () {
            Route::delete('/course', [AdminController::class, 'deleteCourse']);
            Route::delete('/admin/instructor', [AdminController::class, 'deleteInstructor']);
            Route::delete('/schedule', [AdminController::class, 'archiveSubjectSchedule']);
        });

        Route::group(['prefix' => 'search'], function () {
            Route::post('/admin/course-info', [AdminController::class, 'searchCourseInfo']);
            Route::post('/admin/graduates', [AdminController::class, 'searchGraduates']);
            Route::post('/admin/undergraduates', [AdminController::class, 'searchUndergraduates']);
            Route::post('/admin/attendance', [AdminController::class, 'searchViewAttendance']);
            Route::post('/admin/schedule', [AdminController::class, 'searchSchedule']);
            Route::post('/admin/student-attendance', [AdminController::class, 'searchStudentAttendance']);
        });

    });

    Route::group(['middleware' => 'registrar'], function () {
        
        Route::group(['prefix' => 'create'], function () {

            Route::post('/course', [AdminController::class, 'createCourse']);
            Route::post('/course-info', [AdminController::class, 'createCourseInfo']);
            Route::post('/instructor', [AdminController::class, 'createInstructor']);
            Route::post('/schedule', [AdminController::class, 'createSubjectSchedule']);
            Route::post('/subjects', [AdminController::class, 'getSubjects']);
            Route::post('/subject-schedule', [AdminController::class, 'getSubjectSchedule']);
            Route::post('/course-info-subject', [AdminController::class, 'getCourseInfoSubject']);

        }); 

        Route::group(['prefix' => 'update'], function () { 
            Route::patch('/exam-schedule', [RegistrarController::class, 'updateExamSchedule']);
            Route::patch('/proceed-to-interview', [RegistrarController::class, 'updateProceedToInterview']);
            Route::patch('/proceed-to-second-interview', [RegistrarController::class, 'updateProceedToSecondInterview']);
            Route::patch('/proceed-to-final-result', [RegistrarController::class, 'updateProceedToFinalResult']);
            Route::patch('/admission-passed', [RegistrarController::class, 'updateAdmissionPassed']);
            Route::patch('/enroll-student', [RegistrarController::class, 'enrollStudent']);
            Route::patch('/grades', [RegistrarController::class, 'updateGrades']);
            Route::patch('/grades-data-value', [RegistrarController::class, 'updateGradesDataValue']);

            Route::patch('/failed-exam', [RegistrarController::class, 'failedExam']);
            Route::patch('/failed-interview', [RegistrarController::class, 'failedInterview']);
            Route::patch('/failed-admission', [RegistrarController::class, 'failedAdmission']);

            Route::patch('/registrar/admission-status', [RegistrarController::class, 'admissionStatus']);

            Route::patch('/graduate-student', [RegistrarController::class, 'graduateStudent']);
            Route::patch('/employment-status', [RegistrarController::class, 'updateEmploymentStatus']);
            Route::patch('/student-information', [RegistrarController::class, 'updateStudentInformation']);

            Route::patch('/course', [AdminController::class, 'updateCourse']);
            Route::patch('/instructor', [AdminController::class, 'updateInstructor']);
            Route::patch('/schedule', [AdminController::class, 'updateSubjectSchedule']);
            Route::patch('/course-info', [AdminController::class, 'updateCourseInfo']);
            Route::patch('/sms-token', [AdminController::class, 'updateSMSToken']);
        });
        
        Route::group(['prefix' => 'delete'], function () {
            Route::delete('/course', [AdminController::class, 'deleteCourse']);
            Route::delete('/instructor', [AdminController::class, 'deleteInstructor']);
            Route::delete('/schedule', [AdminController::class, 'archiveSubjectSchedule']);
        });

        Route::group(['prefix' => 'search'], function () {
            Route::post('/unscheduled', [RegistrarController::class, 'searchUnscheduled']);
            Route::post('/exam', [RegistrarController::class, 'searchExam']);
            Route::post('/interview', [RegistrarController::class, 'searchInterview']);
            Route::post('/final-result', [RegistrarController::class, 'searchFinalResult']);
            Route::post('/enrollment', [RegistrarController::class, 'searchEnrollment']);
            Route::post('/grades', [RegistrarController::class, 'searchGrades']);
            Route::post('/graduates', [RegistrarController::class, 'searchGraduates']);
            Route::post('/undergraduates', [RegistrarController::class, 'searchUndergraduates']);
            Route::post('/attendance', [RegistrarController::class, 'searchViewAttendance']);
            Route::post('/student-attendance', [RegistrarController::class, 'searchStudentAttendance']);

            Route::post('/specific-schedule', [RegistrarController::class, 'getSpecificSchedule']);
            Route::post('/course-info', [AdminController::class, 'searchCourseInfo']);
            Route::post('/grades-year-semester', [RegistrarController::class, 'searchGradesYearSemester']);
            Route::post('/schedule', [AdminController::class, 'searchSchedule']);

            Route::get('/get-subjects-for-grades', [RegistrarController::class, 'getSubjectsForGrades']);
            Route::get('/get-sections-for-grades', [RegistrarController::class, 'getSectionsForGrades']);

            Route::post('/students-for-grading', [RegistrarController::class, 'studentsForGrading']);
            Route::post('/rfid-information', [RegistrarController::class, 'searchRFIDInformation']);
        });

    });

    Route::group(['middleware' => 'trainer'], function () {
        
        Route::group(['prefix' => 'create'], function () {
        }); 

        Route::group(['prefix' => 'update'], function () {
        });
        
        Route::group(['prefix' => 'delete'], function () {
        });

        Route::group(['prefix' => 'search'], function () {
            
            Route::get('/get-school-year', [TrainerController::class, 'getSchoolYear']);
            Route::get('/get-year-semester', [TrainerController::class, 'getYearSemester']);
            Route::post('/grades-instructor', [TrainerController::class, 'gradesInstructor']);
          
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

        Route::group(['prefix' => 'search'], function () {
            Route::post('/student/schedule', [StudentController::class, 'searchSchedule']);
            Route::post('/student/grades-year-semester', [StudentController::class, 'searchGradesYearSemester']);
            Route::post('/student/student-attendance', [StudentController::class, 'searchStudentAttendance']);
        });

    });
});
