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

use App\Repositories\Interfaces\StudentInterface;

use App\Models\Barangay;
use App\Models\Logs;
use App\Models\Municipal;
use App\Models\Province;
use App\Modes\Region;
use App\Models\User;
use App\Models\Courses;
use App\Models\CoursesInfo;

use App\Models\DocumentsPSA;
use App\Models\DocumentsForm137;

use App\Models\LearnersClass;
use App\Models\LearnersCourse;
use App\Models\LearnersProfile;
use App\Models\LearnersWork;
use App\Models\Schedule;
use App\Models\SubjectSchedule;
use App\Models\Tracker;
use App\Models\StudentYearLevel;
use App\Models\RFIDAttendance;

use Illuminate\Support\Facades\Gate;

class StudentController extends Controller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(
        protected AESCipher $aes,
        protected StudentInterface $StudentInterface
    ) {}
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function dashboard() {
        $psa = $this->StudentInterface->PSA();
        $form137 = $this->StudentInterface->Form137();
        $tracker = $this->StudentInterface->Tracker();
        $yearLevel = $this->StudentInterface->yearLevel();
        $studentGrading = $this->StudentInterface->studentGrading();
        $showProceed = $this->showProceed();

        return view('pages.student.dashboard', compact('psa', 'form137', 'tracker', 'showProceed', 'yearLevel', 'studentGrading'));
    }
    public function coursesInfo(Request $request) {
        $course = $this->StudentInterface->CourseInfo($request);
        $courseInfo = $this->StudentInterface->getCourseInfo($request);
        $subjects = $this->StudentInterface->Subjects($request);
        return view('pages.student.courses-info', compact('course', 'courseInfo', 'subjects'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function uploadPSA(Request $request) {

        foreach ($request->file('files') as $file) {

            $timestamp = Carbon::now();
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $customFileName = \Str::slug($originalName.'-'.$timestamp).'.'.$extension;
            $transferfile = $file->storeAs('public/documents/PSA/', $customFileName);    

            $data = [
                'studentID' => Auth::user()->Student->id,
                'filename' => $customFileName,
            ];
            DocumentsPSA::create($data);
        }

        $psa = $this->StudentInterface->PSA();
        $aes = $this->aes;
        $showProceed = $this->showProceed();

        return response()->json([
            'Message' => 'Document uploaded successfully',
            'Attachments' => view('data.student.psa-data', compact('aes','psa'))->render(),
            'Proceed' => view('data.student.proceed-data', ['showProceed' => $showProceed])->render()
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deletePSA(Request $request, DocumentsPSA $documentPSA) {

        $id = $this->aes->decrypt($request->id);

        if (! Gate::allows('delete-psa', auth()->user()->Student->id)) {
            return response()->json(['Message' => 'Unauthorized'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $psa = DocumentsPSA::where('id', $id)->first();
        File::delete(public_path("storage/documents/PSA/{$psa->filename}"));
        DocumentsPSA::where('id', $id)->delete();

        $psa = $this->StudentInterface->PSA();
        $aes = $this->aes;
        $showProceed = $this->showProceed();

        return response()->json([
            'Message' => 'Document deleted successfully',
            'Attachments' => view('data.student.psa-data', compact('aes','psa'))->render(),
            'Proceed' => view('data.student.proceed-data', ['showProceed' => $showProceed])->render()
        ], Response::HTTP_OK);
            
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function uploadForm137(Request $request) {

        foreach ($request->file('files') as $file) {

            $timestamp = Carbon::now();
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $customFileName = \Str::slug($originalName.'-'.$timestamp).'.'.$extension;
            $transferfile = $file->storeAs('public/documents/Form137/', $customFileName);    

            $data = [
                'studentID' => Auth::user()->Student->id,
                'filename' => $customFileName,
            ];
            DocumentsForm137::create($data);
        }

        $form137 = $this->StudentInterface->Form137();
        $aes = $this->aes;
        $showProceed = $this->showProceed();

        return response()->json([
            'Message' => 'Document uploaded successfully',
            'Attachments' => view('data.student.form137-data', compact('aes','form137'))->render(),
            'Proceed' => view('data.student.proceed-data', ['showProceed' => $showProceed])->render()
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteForm137(Request $request) {

        $id = $this->aes->decrypt($request->id);

        if (! Gate::allows('delete-form137', auth()->user()->Student->id)) {
            return response()->json(['Message' => 'Unauthorized'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $form137 = DocumentsForm137::where('id', $id)->first();
        File::delete(public_path("storage/documents/Form137/{$form137->filename}"));
        DocumentsForm137::where('id', $id)->delete();

        $form137 = $this->StudentInterface->Form137();
        $aes = $this->aes;
        $showProceed = $this->showProceed();

        return response()->json([
            'Message' => 'Document deleted successfully',
            'Attachments' => view('data.student.form137-data', compact('aes','form137'))->render(),
            'Proceed' => view('data.student.proceed-data', ['showProceed' => $showProceed])->render()
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function showProceed() {
        if($this->StudentInterface->Form137()->count() != 0 && $this->StudentInterface->PSA()->count() != 0)
            return true;
        else
            return false;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function proceedReview(Request $request) {

        if($request->status == true) {
            $tracker = Tracker::where('studentID', Auth::user()->Student->id)
                ->orderBy('created_at', 'DESC')
                ->first();
            
            $newTracker = $tracker->tracker + 1;

            Tracker::create([
                'studentID' => Auth::user()->Student->id,
                'tracker' => $newTracker
            ]);

            LearnersProfile::where('id', Auth::user()->Student->id)->update(['status' => 2]);

            return response()->json([], Response::HTTP_OK);
        }
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function registrationForm() {
        $learnersProfile = $this->StudentInterface->LearnersProfile();
        $learnersClass = $this->StudentInterface->LearnersClass();
        $learnersWork = $this->StudentInterface->LearnersWork();
        $learnersCourse = $this->StudentInterface->LearnersCourse();
        return view('pages.student.form.registration-form', compact('learnersProfile', 'learnersClass', 'learnersWork', 'learnersCourse'));
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function proceedEnrollment() {
        
        LearnersProfile::where('id', Auth::user()->Student->id)->update([
            'admission_status' => 0,
            'progress' => 1,
            'yearLevel' => 1,
            'semester' => 1,
            'enrollmentStatus' => 1,
            'freshmen' => 1
        ]);

        return redirect('/student/dashboard');
    }

    public function cancelEnrollment() {
        
        LearnersProfile::where('id', Auth::user()->Student->id)->update([
            'admission_status' => 2,
        ]);

        return redirect('/student/dashboard');
    }

    public function schedule() {
        $yearLevel = $this->StudentInterface->yearLevel();
        $subjectSchedule = $this->StudentInterface->subjectSchedule();

        $courseInfo = CoursesInfo::where('courseID', Auth::user()->Student->LearnersCourse->course)
        ->orderBy('yearLevel', 'ASC')
        ->orderBy('semester', 'ASC')
        ->get();

        $schoolYears = Schedule::select('schoolYear')->distinct()->where('courseID', Auth::user()->Student->LearnersCourse->course)->get();
        return view('pages.student.schedule', compact('yearLevel', 'subjectSchedule', 'schoolYears', 'courseInfo'));
    }

    public function grades() {
        $yearLevel = $this->StudentInterface->yearLevel();
        $studentGrading = $this->StudentInterface->studentGrading();
        $courseInfo = CoursesInfo::where('courseID', Auth::user()->Student->LearnersCourse->course)->get();
        return view('pages.student.grades', compact('yearLevel', 'studentGrading', 'courseInfo'));
    }
    
   public function attendance(Request $request) {
       $attendance = $this->StudentInterface->RFIDAttendance();
       return view('pages.student.attendance', compact('attendance'));
   }

   public function searchSchedule(Request $request) {

        
            $yearLevel = StudentYearLevel::where('studentID', Auth::user()->Student->id)
                ->whereHas('Schedule', function ($query) use ($request) {
                    $query->where('schoolYear', $request->schoolYear)
                        ->where('courseInfoID', $this->aes->decrypt($request->yearSemester));
                })
                    ->with(['Schedule']) // Eager load the Schedule relationship
                    ->orderBy('courseInfoID', 'ASC')
                    ->get();

            $subjectSchedule = $this->StudentInterface->subjectSchedule();
            $aes = $this->aes;

            return response()->json([
                'schedule' => view('data.student.schedule-subject-course-data', compact('subjectSchedule', 'aes', 'yearLevel'))->render()
            ], Response::HTTP_OK);
    }

    public function searchGradesYearSemester(Request $request) {

        $yearLevel = StudentYearLevel::where('studentID', Auth::user()->Student->id)
        ->where('courseInfoID', $this->aes->decrypt($request->search))
        ->orderBy('scheduleID', 'DESC')->get();

        $studentGrading = $this->StudentInterface->studentGrading();
        $aes = $this->aes;

        return response()->json([
            'Grades' => view('data.student.grades-data', compact('yearLevel', 'studentGrading', 'aes'))->render(),
        ], Response::HTTP_OK); 
    }


    public function searchStudentAttendance(Request $request) {
        $attendance = RFIDAttendance::where('studentID', Auth::user()->Student->id)
        ->where('yearLevel', $request->yearLevel)
        ->where('month', $request->month)
        ->orderBy('created_at', 'DESC')
        ->get()
        ->groupBy('yearLevel');

        $aes = $this->aes;
        return response()->json([
            'Attendance' => view('data.student.attendance-data', compact('attendance', 'aes'))->render()
        ]);
    }

    public function ORF(Request $request) {
        $student = StudentYearLevel::where('studentID', Auth::user()->Student->id)
        ->where('scheduleID', $this->aes->decrypt($request->id))
        ->first();

        $schedule = Schedule::where('id', $student->scheduleID)->first();
        $subjectSchedule = SubjectSchedule::where('scheduleID', $student->scheduleID)->get();

        return view('pages.ORF', compact('schedule', 'subjectSchedule', 'student'));
    }
}
