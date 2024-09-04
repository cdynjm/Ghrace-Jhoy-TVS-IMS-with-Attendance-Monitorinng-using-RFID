<?php

namespace App\Http\Controllers;

use Hash;
use Session;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Response;

use App\Http\Controllers\AESCipher;

use App\Repositories\Interfaces\RegistrarInterface;

use App\Models\Barangay;
use App\Models\Logs;
use App\Models\Municipal;
use App\Models\Province;
use App\Modes\Region;
use App\Models\User;
use App\Models\Courses;
use App\Models\CoursesInfo;
use App\Models\StudentGrading;
use App\Models\StudentYearLevel;
use App\Models\Schedule;
use App\Models\SubjectSchedule;
use App\Models\AdmissionApplication;

use App\Models\LearnersClass;
use App\Models\LearnersCourse;
use App\Models\LearnersProfile;
use App\Models\LearnersWork;

use App\Models\Tracker;

class RegistrarController extends Controller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(
        protected AESCipher $aes,
        protected RegistrarInterface $RegistrarInterface
    ) {}
    public function admissionStatus(Request $request) {
        AdmissionApplication::where('id', 1)->update(['status' => $this->aes->decrypt($request->status)]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function dashboard() {
        $student = $this->RegistrarInterface->Students();
        return view('pages.registrar.dashboard', ['student' => $student]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function enrollGrades() {
        $courses = $this->RegistrarInterface->Courses();
        return view('pages.registrar.enroll-grades', ['courses' => $courses]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function graduates() {
        $courses = $this->RegistrarInterface->Courses();
        return view('pages.registrar.graduates', ['courses' => $courses]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function undergraduates() {
        $courses = $this->RegistrarInterface->Courses();
        return view('pages.registrar.undergraduates', ['courses' => $courses]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function unscheduled() {

        $learnersProfile = $this->RegistrarInterface->UnscheduledLearnersProfile();
        $learnersCourse = $this->RegistrarInterface->UnscheduledLearnersCourse();
        $psa = $this->RegistrarInterface->PSA();
        $form137 = $this->RegistrarInterface->Form137();

        return view('pages.registrar.admission.unscheduled', compact('psa', 'form137', 'learnersProfile', 'learnersCourse'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function exam() {
        $learnersProfile = $this->RegistrarInterface->ExamLearnersProfile();
        $learnersCourse = $this->RegistrarInterface->ExamLearnersCourse();
        return view('pages.registrar.admission.exam', compact('learnersProfile', 'learnersCourse'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function interview() {
        $learnersProfile = $this->RegistrarInterface->InterviewLearnersProfile();
        $secondLearnersProfile = $this->RegistrarInterface->SecondInterviewLearnersProfile();
        $learnersCourse = $this->RegistrarInterface->InterviewLearnersCourse();
        return view('pages.registrar.admission.interview', compact('learnersProfile', 'learnersCourse', 'secondLearnersProfile'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function finalResult() {
        $learnersProfile = $this->RegistrarInterface->FinalResultLearnersProfile();
        $learnersCourse = $this->RegistrarInterface->FinalResultLearnersCourse();
        return view('pages.registrar.admission.final-result', compact('learnersProfile', 'learnersCourse'));
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function registrationForm(Request $request) {
        $learnersProfile = $this->RegistrarInterface->LearnersProfile($request);
        $learnersClass = $this->RegistrarInterface->LearnersClass($request);
        $learnersWork = $this->RegistrarInterface->LearnersWork($request);
        $learnersCourse = $this->RegistrarInterface->LearnersCourse($request);
        return view('pages.registrar.form.registration-form', compact('learnersProfile', 'learnersClass', 'learnersWork', 'learnersCourse'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateExamSchedule(Request $request) {

        foreach($request->applicant as $key => $value) {
            LearnersProfile::where('id', $this->aes->decrypt($value))->update([
                'exam' => $request->date,
                'status' => 3
            ]);

            $tracker = Tracker::where('studentID', $this->aes->decrypt($value))
                ->orderBy('created_at', 'DESC')
                ->first();
            
            $newTracker = $tracker->tracker + 1;

            Tracker::create([
                'studentID' => $this->aes->decrypt($value),
                'tracker' => $newTracker
            ]);
        }

        $learnersProfile = $this->RegistrarInterface->UnscheduledLearnersProfile();
        $learnersCourse = $this->RegistrarInterface->UnscheduledLearnersCourse();
        $psa = $this->RegistrarInterface->PSA();
        $form137 = $this->RegistrarInterface->Form137();
        $status = $this->RegistrarInterface->Status();
        $aes = $this->aes;

        return response()->json([
            'Message' => 'Scheduled Set Successfully!',
            'Unscheduled' => view('data.registrar.unscheduled-data', compact('aes', 'psa', 'form137', 'learnersProfile', 'learnersCourse'))->render(),
            'Status' => view('layouts.sidebar', compact('status'))->render()
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function failedExam(Request $request) {

        foreach($request->applicant as $key => $value) {
            LearnersProfile::where('id', $this->aes->decrypt($value))->update([
                'failed' => 1
            ]);
        }

        $learnersProfile = $this->RegistrarInterface->ExamLearnersProfile();
        $learnersCourse = $this->RegistrarInterface->ExamLearnersCourse();
        $status = $this->RegistrarInterface->Status();
        $aes = $this->aes;

        return response()->json([
            'Message' => 'Selected Applicant/s has been marked as failed successfully!',
            'Exam' => view('data.registrar.exam-data', compact('aes', 'learnersProfile', 'learnersCourse'))->render(),
            'Status' => view('layouts.sidebar', compact('status'))->render()
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateProceedToInterview(Request $request) {

        foreach($request->applicant as $key => $value) {
            LearnersProfile::where('id', $this->aes->decrypt($value))->update([
                'interview' => $request->date,
                'status' => 4
            ]);

            $tracker = Tracker::where('studentID', $this->aes->decrypt($value))
                ->orderBy('created_at', 'DESC')
                ->first();
            
            $newTracker = $tracker->tracker + 1;

            Tracker::create([
                'studentID' => $this->aes->decrypt($value),
                'tracker' => $newTracker
            ]);
        }

        $learnersProfile = $this->RegistrarInterface->ExamLearnersProfile();
        $learnersCourse = $this->RegistrarInterface->ExamLearnersCourse();
        $status = $this->RegistrarInterface->Status();
        $aes = $this->aes;

        return response()->json([
            'Message' => 'Selected Applicant/s has been scheduled for interview successfully!',
            'Exam' => view('data.registrar.exam-data', compact('aes', 'learnersProfile', 'learnersCourse'))->render(),
            'Status' => view('layouts.sidebar', compact('status'))->render()
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function failedInterview(Request $request) {

        foreach($request->applicant as $key => $value) {
            LearnersProfile::where('id', $this->aes->decrypt($value))->update([
                'failed' => 1
            ]);
        }

        $learnersProfile = $this->RegistrarInterface->InterviewLearnersProfile();
        $secondLearnersProfile = $this->RegistrarInterface->SecondInterviewLearnersProfile();
        $learnersCourse = $this->RegistrarInterface->InterviewLearnersCourse();
        $status = $this->RegistrarInterface->Status();
        $aes = $this->aes;

        return response()->json([
            'Message' => 'Selected Applicant/s has been marked as failed successfully!',
            'Interview' => view('data.registrar.interview-data', compact('aes', 'learnersProfile', 'learnersCourse', 'secondLearnersProfile'))->render(),
            'Status' => view('layouts.sidebar', compact('status'))->render()
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateProceedToSecondInterview(Request $request) {

        foreach($request->applicant as $key => $value) {
            LearnersProfile::where('id', $this->aes->decrypt($value))->update([
                'secondInterview' => $request->date,
                'status' => 5,
            ]);

            $tracker = Tracker::where('studentID', $this->aes->decrypt($value))
                ->orderBy('created_at', 'DESC')
                ->first();
            
            $newTracker = $tracker->tracker + 1;

            Tracker::create([
                'studentID' => $this->aes->decrypt($value),
                'tracker' => $newTracker
            ]);
        }

        $learnersProfile = $this->RegistrarInterface->InterviewLearnersProfile();
        $secondLearnersProfile = $this->RegistrarInterface->SecondInterviewLearnersProfile();
        $learnersCourse = $this->RegistrarInterface->InterviewLearnersCourse();
        $status = $this->RegistrarInterface->Status();
        $aes = $this->aes;

        return response()->json([
            'Message' => 'Selected Applicant/s has been scheduled for second interview successfully!',
            'Interview' => view('data.registrar.interview-data', compact('aes', 'learnersProfile', 'learnersCourse', 'secondLearnersProfile'))->render(),
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateProceedToFinalResult(Request $request) {

        foreach($request->applicant as $key => $value) {
            LearnersProfile::where('id', $this->aes->decrypt($value))->update(['status' => 6]);

            $tracker = Tracker::where('studentID', $this->aes->decrypt($value))
                ->orderBy('created_at', 'DESC')
                ->first();
            
            $newTracker = $tracker->tracker + 1;

            Tracker::create([
                'studentID' => $this->aes->decrypt($value),
                'tracker' => $newTracker
            ]);
        }

        $learnersProfile = $this->RegistrarInterface->InterviewLearnersProfile();
        $secondLearnersProfile = $this->RegistrarInterface->SecondInterviewLearnersProfile();
        $learnersCourse = $this->RegistrarInterface->InterviewLearnersCourse();
        $status = $this->RegistrarInterface->Status();
        $aes = $this->aes;

        return response()->json([
            'Message' => 'Selected Applicant/s has been confirmed for the final evaluation successfully!',
            'Interview' => view('data.registrar.interview-data', compact('aes', 'learnersProfile', 'learnersCourse', 'secondLearnersProfile'))->render(),
            'Status' => view('layouts.sidebar', compact('status'))->render()
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateAdmissionPassed(Request $request) {

        foreach($request->applicant as $key => $value) {
            LearnersProfile::where('id', $this->aes->decrypt($value))->update([
                'status' => 7,
            ]);

            $tracker = Tracker::where('studentID', $this->aes->decrypt($value))
                ->orderBy('created_at', 'DESC')
                ->first();
            
            $newTracker = $tracker->tracker + 1;

            Tracker::create([
                'studentID' => $this->aes->decrypt($value),
                'tracker' => $newTracker
            ]);
        }

        $learnersProfile = $this->RegistrarInterface->FinalResultLearnersProfile();
        $learnersCourse = $this->RegistrarInterface->FinalResultLearnersCourse();
        $status = $this->RegistrarInterface->Status();
        $aes = $this->aes;

        return response()->json([
            'Message' => 'Selected Applicant/s has been confirmed as PASSED successfully!',
            'FinalResult' => view('data.registrar.final-result-data', compact('aes', 'learnersProfile', 'learnersCourse'))->render(),
            'Status' => view('layouts.sidebar', compact('status'))->render()
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function failedAdmission(Request $request) {

        foreach($request->applicant as $key => $value) {
            LearnersProfile::where('id', $this->aes->decrypt($value))->update([
                'failed' => 1
            ]);
        }

        $learnersProfile = $this->RegistrarInterface->FinalResultLearnersProfile();
        $learnersCourse = $this->RegistrarInterface->FinalResultLearnersCourse();
        $status = $this->RegistrarInterface->Status();
        $aes = $this->aes;

        return response()->json([
            'Message' => 'Selected Applicant/s has been marked as failed successfully!',
            'FinalResult' => view('data.registrar.final-result-data', compact('aes', 'learnersProfile', 'learnersCourse'))->render(),
            'Status' => view('layouts.sidebar', compact('status'))->render()
        ], Response::HTTP_OK);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function viewGraduates(Request $request) {
        $course = $this->RegistrarInterface->CourseInfo($request);
        $graduates = $this->RegistrarInterface->Graduates($request);
        return view('pages.registrar.view-graduates', compact('graduates', 'course'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function viewUndergraduates(Request $request) {
        $course = $this->RegistrarInterface->CourseInfo($request);
        $undergraduates = $this->RegistrarInterface->Undergraduates($request);
        return view('pages.registrar.view-undergraduates', compact('undergraduates', 'course'));
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function enrollment(Request $request) {

        $course = $this->RegistrarInterface->CourseInfo($request);
        $enrollees = $this->RegistrarInterface->Enrollees($request);
        $schedule = $this->RegistrarInterface->Schedule();
        return view('pages.registrar.enrollment', compact('course', 'enrollees', 'schedule'));
    }

    public function enrollStudent(Request $request) {

        $schedule = Schedule::where('id', $this->aes->decrypt($request->schedule))->first();
        $schedule->enrolled += 1;
        Schedule::where('id', $this->aes->decrypt($request->schedule))->update(['enrolled' => $schedule->enrolled]);

        $studentYearLevel = StudentYearLevel::create([
            'studentID' => $this->aes->decrypt($request->studentID),
            'scheduleID' => $schedule->id,
            'courseInfoID' => $schedule->CourseInfo->id
        ]);

        foreach(SubjectSchedule::where('courseInfoID', $schedule->CourseInfo->id)->where('scheduleID', $schedule->id)->get() as $sub) {
            StudentGrading::create([
                'studentYearLevelID' => $studentYearLevel->id,
                'studentID' => $this->aes->decrypt($request->studentID),
                'courseInfoID' => $schedule->CourseInfo->id,
                'subjectID' => $sub->Subjects->id,
                'instructor' => $sub->instructor,
                'mt' => 0,
                'ft' => 0,
                'avg' => 0,
                'assessment' => 0
            ]);
        }

        $student = LearnersProfile::where('id', $this->aes->decrypt($request->studentID))->first();

        if($student->freshmen == 1) {
            LearnersProfile::where('id', $this->aes->decrypt($request->studentID))->update([
                'enrollmentStatus' => 0,
                'freshmen' => 0
            ]);
        }

        else if($student->semester == 1) {
            $student->semester += 1;
            LearnersProfile::where('id', $this->aes->decrypt($request->studentID))->update([
                'enrollmentStatus' => 0,
                'semester' =>  $student->semester,
                'progress' => $student->progress + 1
            ]);
        }

        else if($student->semester == 2) {
            $student->yearLevel += 1;
            LearnersProfile::where('id', $this->aes->decrypt($request->studentID))->update([
                'enrollmentStatus' => 0,
                'semester' =>  1, 
                'yearLevel' => $student->yearLevel,
                'progress' => $student->progress + 1
            ]);
        }
        
        else {}

        $course = $this->RegistrarInterface->CourseInfo($request);
        $enrollees = $this->RegistrarInterface->Enrollees($request);
        $schedule = $this->RegistrarInterface->Schedule();
        $aes = $this->aes;

        return response()->json([
            'Message' => 'Student Enrolled Successfully',
            'Enrollees' => view('data.registrar.enrollment-data', compact('course', 'enrollees', 'schedule', 'aes'))->render(),
            'Schedule' => view('modals.registrar.update.schedule.schedule-list', compact('schedule', 'aes'))->render(),
        ], Response::HTTP_OK); 
    }

    public function grades(Request $request) {

        $course = $this->RegistrarInterface->CourseInfo($request);
        $enrollees = $this->RegistrarInterface->StudentGrades($request);
        $schedule = $this->RegistrarInterface->Schedule();
        return view('pages.registrar.grades', compact('course', 'enrollees', 'schedule'));
    }

    public function editGrades(Request $request) {

        $yearLevel = $this->RegistrarInterface->yearLevel($request);
        $studentGrading = $this->RegistrarInterface->studentGrading($request);
        $student = $this->RegistrarInterface->LearnersProfile($request);
        return view('pages.registrar.edit-grades', compact('yearLevel', 'studentGrading', 'student'));
    }

    public function updateGrades(Request $request) {
        $mt = $request->mt;
        $ft = $request->ft;
    
        // Calculate the average
        $avg = ($mt > 0 && $ft > 0) 
            ? ($mt + $ft) / 2 
            : ($mt > 0 ? $mt : ($ft > 0 ? $ft : 0));
    

        StudentGrading::where('id', $this->aes->decrypt($request->gradeID))->update([
            'mt' => $mt,
            'ft' => $ft,
            'avg' => $avg,
            'assessment' => $request->assessment ?? 0
        ]);
    
        // Check if all grades, including assessment, are filled for this student
        $allGraded = StudentGrading::where('studentID', $this->aes->decrypt($request->id))
            ->where(function ($query) {
                $query->where('mt', 0)
                      ->orWhere('ft', 0)
                      ->orWhere(function ($query) {
                          $query->whereHas('Subjects', function ($query) {
                              $query->where('NC', 1);
                          })->where('assessment', 0);
                      });
            })
            ->doesntExist();
    
        // Update the enrollment status based on the grading status
        $statusValue = $allGraded ? 1 : 0;
        
        $coursesInfo = CoursesInfo::where('courseID', StudentGrading::where('studentID', $this->aes->decrypt($request->id))->first()->Subjects->courseID)->count();
        $studentProgress = LearnersProfile::where('id', $this->aes->decrypt($request->id))->first();
        
        if($allGraded) {
            if($coursesInfo == $studentProgress->progress) {
                LearnersProfile::where('id', $this->aes->decrypt($request->id))->update([
                    'enrollmentStatus' => 2,
                ]);
            }
            else {
                LearnersProfile::where('id', $this->aes->decrypt($request->id))->update([
                    'enrollmentStatus' => $statusValue,
                ]);
            }
        }
        else {
            LearnersProfile::where('id', $this->aes->decrypt($request->id))->update([
                'enrollmentStatus' => $statusValue,
            ]);
        }
    
        // Fetch related data for the response
        $yearLevel = $this->RegistrarInterface->yearLevel($request);
        $studentGrading = $this->RegistrarInterface->studentGrading($request);
        $student = $this->RegistrarInterface->LearnersProfile($request);
        $aes = $this->aes;
    
        // Return a JSON response
        return response()->json([
            'Message' => 'Grades updated successfully',
            'Grades' => view('data.registrar.edit-grades-data', compact('yearLevel', 'studentGrading', 'student', 'aes'))->render()
        ], Response::HTTP_OK);
    }

    public function graduateStudent(Request $request) {

        LearnersProfile::where('id', $this->aes->decrypt($request->studentID))->update([
            'diploma' => 1,
            'dateGraduated' => date('Y-m-d')
        ]);

        $course = $this->RegistrarInterface->CourseInfo($request);
        $enrollees = $this->RegistrarInterface->Enrollees($request);
        $schedule = $this->RegistrarInterface->Schedule();
        $aes = $this->aes;

        return response()->json([
            'Message' => 'Student Information updated Successfully',
            'Enrollees' => view('data.registrar.enrollment-data', compact('course', 'enrollees', 'schedule', 'aes'))->render(),
            'Schedule' => view('modals.registrar.update.schedule.schedule-list', compact('schedule', 'aes'))->render(),
        ], Response::HTTP_OK); 
    }

    public function updateEmploymentStatus(Request $request) {

        LearnersProfile::where('id', $this->aes->decrypt($request->studentID))->update([
            'graduateEmploymentStatus' => $request->employmentStatus,
            'company' => $request->company,
            'dateHired' => $request->dateHired 
        ]);

        $course = $this->RegistrarInterface->CourseInfo($request);
        $graduates = $this->RegistrarInterface->Graduates($request);
        $aes = $this->aes;

        return response()->json([
            'Message' => 'Employment status updated Successfully',
            'Graduates' => view('data.registrar.view-graduates-data', compact('graduates', 'aes', 'course'))->render(),
        ], Response::HTTP_OK); 
    
    }

    public function updateStudentInformation(Request $request) {

        LearnersProfile::where('id', $this->aes->decrypt($request->studentID))->update([
            'RFID' => $request->RFID,
            'ULI' => $request->ULI,
        ]);

        $course = $this->RegistrarInterface->CourseInfo($request);
        $undergraduates = $this->RegistrarInterface->Undergraduates($request);
        $aes = $this->aes;

        return response()->json([
            'Message' => 'RFID & ULI information has been updated Successfully',
            'Undergraduates' => view('data.registrar.view-undergraduates-data', compact('undergraduates', 'aes', 'course'))->render(),
        ], Response::HTTP_OK); 
    
    }
    
}
