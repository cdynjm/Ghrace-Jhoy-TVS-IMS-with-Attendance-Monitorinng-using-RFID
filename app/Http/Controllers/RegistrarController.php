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
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function dashboard() {

        return view('pages.registrar.dashboard');
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function courses() {
        $courses = $this->RegistrarInterface->Courses();
        return view('pages.registrar.courses', ['courses' => $courses]);
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
    public function enrollment(Request $request) {

        $course = $this->RegistrarInterface->CourseInfo($request);
        $enrollees = $this->RegistrarInterface->Enrollees($request);
        return view('pages.registrar.enrollment', compact('course', 'enrollees'));
    }
}
