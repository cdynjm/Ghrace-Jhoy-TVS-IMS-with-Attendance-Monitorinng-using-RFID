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

use App\Repositories\Interfaces\TrainerInterface;

use App\Models\Barangay;
use App\Models\Logs;
use App\Models\Municipal;
use App\Models\Province;
use App\Modes\Region;
use App\Models\User;
use App\Models\Courses;
use App\Models\CoursesInfo;

use App\Models\LearnersClass;
use App\Models\LearnersCourse;
use App\Models\LearnersProfile;
use App\Models\LearnersWork;
use App\Models\Schedule;
use App\Models\SubjectSchedule;

class TrainerController extends Controller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(
        protected AESCipher $aes, 
        protected TrainerInterface $TrainerInterface
    ) {}

    public function dashboard() {
        $schedule = $this->TrainerInterface->Schedule();
        return view('pages.trainer.dashboard', compact('schedule'));
    }

    public function grades() {
        $schedule = $this->TrainerInterface->Grades();
        $courses = Courses::get();
        return view('pages.trainer.grades', compact('schedule', 'courses'));
    }

    public function students(Request  $request) {
        $students = $this->TrainerInterface->Students($request);
        $schedule = $this->TrainerInterface->getSchedule($request);
        $grading = $this->TrainerInterface->Grading($request);
        return view('pages.trainer.students', compact('students', 'schedule', 'grading'));
    }

    public function getSchoolYear(Request $request) {
        $schoolYears = Schedule::select('schoolYear')->distinct()->where('courseID', $this->aes->decrypt($request->course))->get();
        return response()->json([
            'Years' => $schoolYears
        ]);
    }

    public function getYearSemester(Request $request) {
        $semester = CoursesInfo::where('courseID', $this->aes->decrypt($request->course))->get();
        return response()->json([
            'semesters' => $semester
        ]);
    }

    public function gradesInstructor(Request $request) {
        $year = $request->schoolYear;
        $schedule = SubjectSchedule::where('instructor', Auth::user()->Instructor->id)
            ->where('courseInfoID', $request->yearSemester)
            ->where('courseID', $this->aes->decrypt($request->course))
            ->whereHas('Schedule', function($query) use ($year) {
                $query->where('schoolYear', $year);
            })
            ->get();
            
        $aes = $this->aes;
        
        return response()->json([
            'Grades' => view('data.trainer.grades-data', compact('schedule', 'aes'))->render()
        ]);
    }
    

}
