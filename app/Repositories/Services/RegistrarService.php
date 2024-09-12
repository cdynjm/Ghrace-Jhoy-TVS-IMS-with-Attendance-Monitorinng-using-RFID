<?php

namespace App\Repositories\Services;

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
use Illuminate\Support\Facades\DB;

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

use App\Models\StudentYearLevel;
use App\Models\StudentGrading;

use App\Models\DocumentsPSA;
use App\Models\DocumentsForm137;

use App\Models\LearnersClass;
use App\Models\LearnersCourse;
use App\Models\LearnersProfile;
use App\Models\LearnersWork;
use App\Models\Schedule;
use App\Models\RFIDAttendance;

class RegistrarService implements RegistrarInterface {

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(
        protected AESCipher $aes
    ) {}

    public function Students() {
        return LearnersProfile::where('diploma', null)->get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function UnscheduledLearnersProfile() {
        return LearnersProfile::where('status', 2)->where('failed', null)->orderBy('lastname', 'ASC')->get();
    }
    public function searchUnscheduledLearnersProfile($request) {
        return LearnersProfile::where('status', 2)
            ->where('failed', null)
            ->where(function($query) use ($request) {
                $query->where('lastname', 'LIKE', '%'.$request->search.'%')
                      ->orWhere('firstname', 'LIKE', '%'.$request->search.'%')
                      ->orWhere('middlename', 'LIKE', '%'.$request->search.'%');
            })
            ->orderBy('lastname', 'ASC')
            ->get();
    }
    
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function UnscheduledLearnersCourse() {
        return LearnersCourse::get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function LearnersProfile($request) {
        return LearnersProfile::where('id', $this->aes->decrypt($request->id))->first();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function LearnersCourse($request) {
        return LearnersCourse::where('studentID', $this->aes->decrypt($request->id))->first();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function LearnersClass($request) {
        return LearnersClass::where('studentID', $this->aes->decrypt($request->id))->get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function LearnersWork($request) {
        return LearnersWork::where('studentID', $this->aes->decrypt($request->id))->get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function PSA() {
        return DocumentsPSA::get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function Form137() {
        return DocumentsForm137::get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function ExamLearnersProfile() {
        return LearnersProfile::where('status', 3)->where('failed', null)->orderBy('lastname', 'ASC')->get()->groupBy('exam');
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function searchExamLearnersProfile($request) {
        return LearnersProfile::where('status', 3)->where('failed', null)
        ->where(function($query) use ($request) {
            $query->where('lastname', 'LIKE', '%'.$request->search.'%')
                  ->orWhere('firstname', 'LIKE', '%'.$request->search.'%')
                  ->orWhere('middlename', 'LIKE', '%'.$request->search.'%');
        })
        ->orderBy('lastname', 'ASC')
        ->get()->groupBy('exam');
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function ExamLearnersCourse() {
        return LearnersCourse::get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function InterviewLearnersProfile() {
        return LearnersProfile::where('status', 4)->where('failed', null)->orderBy('lastname', 'ASC')->get()->groupBy('interview');
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function SecondInterviewLearnersProfile() {
        return LearnersProfile::where('status', 5)->where('failed', null)->orderBy('lastname', 'ASC')->get()->groupBy('secondInterview');
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function searchInterviewLearnersProfile($request) {
        return LearnersProfile::where('status', 4)->where('failed', null)
        ->where(function($query) use ($request) {
            $query->where('lastname', 'LIKE', '%'.$request->search.'%')
                  ->orWhere('firstname', 'LIKE', '%'.$request->search.'%')
                  ->orWhere('middlename', 'LIKE', '%'.$request->search.'%');
        })
        ->orderBy('lastname', 'ASC')->get()->groupBy('interview');
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function searchSecondInterviewLearnersProfile($request) {
        return LearnersProfile::where('status', 5)->where('failed', null)
        ->where(function($query) use ($request) {
            $query->where('lastname', 'LIKE', '%'.$request->search.'%')
                  ->orWhere('firstname', 'LIKE', '%'.$request->search.'%')
                  ->orWhere('middlename', 'LIKE', '%'.$request->search.'%');
        })
        ->orderBy('lastname', 'ASC')->get()->groupBy('secondInterview');
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function InterviewLearnersCourse() {
        return LearnersCourse::get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function FinalResultLearnersProfile() {
        return LearnersProfile::where('status', 6)->where('failed', null)->orderBy('lastname', 'ASC')->get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function searchFinalResultLearnersProfile($request) {
        return LearnersProfile::where('status', 6)->where('failed', null)
        ->where(function($query) use ($request) {
            $query->where('lastname', 'LIKE', '%'.$request->search.'%')
                  ->orWhere('firstname', 'LIKE', '%'.$request->search.'%')
                  ->orWhere('middlename', 'LIKE', '%'.$request->search.'%');
        })
        ->orderBy('lastname', 'ASC')
        ->get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function FinalResultLearnersCourse() {
        return LearnersCourse::get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function Status() {
        return LearnersProfile::where('admission_status', 1)->get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function Courses() {
        return Courses::orderBy('sector', 'ASC')->get();
    }

    public function CourseInfo($request) {
        return Courses::where('id', $this->aes->decrypt($request->id))->first();
    }

    public function Enrollees($request) {
        return LearnersProfile::whereHas('learnersCourse', function($query) use ($request) {
            $query->where('course', $this->aes->decrypt($request->id))
            ->where('diploma', null)
            ->where('yearLevel', '!=', null);
        })->orderBy('yearLevel', 'ASC')
            ->orderBy('semester', 'ASC')
            ->orderBy('lastname', 'ASC')
            ->get();
    }

    public function searchEnrollees($request) {
        return LearnersProfile::whereHas('learnersCourse', function($query) use ($request) {
                $query->where('course', $this->aes->decrypt($request->id))
                      ->where('diploma', null)
                      ->where('yearLevel', '!=', null);
            })
            ->where(function($query) use ($request) {
                $query->where('lastname', 'LIKE', '%'.$request->search.'%')
                      ->orWhere('firstname', 'LIKE', '%'.$request->search.'%')
                      ->orWhere('middlename', 'LIKE', '%'.$request->search.'%');
            })
            ->orderBy('yearLevel', 'ASC')
            ->orderBy('semester', 'ASC')
            ->orderBy('lastname', 'ASC')
            ->get();
    }
    

    public function StudentGrades($request) {
        return LearnersProfile::whereHas('learnersCourse', function($query) use ($request) {
            $query->where('course', $this->aes->decrypt($request->id))
            ->where('diploma', null)
            ->where('freshmen', 0)
            ->where('yearLevel', '!=', null);
        })->orderBy('yearLevel', 'ASC')
            ->orderBy('lastname', 'ASC')
            ->get()
            ->groupBy('yearLevel');
    }

    public function searchStudentGrades($request) {
        return LearnersProfile::whereHas('learnersCourse', function($query) use ($request) {
            $query->where('course', $this->aes->decrypt($request->id))
            ->where('diploma', null)
            ->where('freshmen', 0)
            ->where('yearLevel', '!=', null);
        })
        ->where(function($query) use ($request) {
            $query->where('lastname', 'LIKE', '%'.$request->search.'%')
                  ->orWhere('firstname', 'LIKE', '%'.$request->search.'%')
                  ->orWhere('middlename', 'LIKE', '%'.$request->search.'%');
        })
        ->orderBy('yearLevel', 'ASC')
            ->orderBy('lastname', 'ASC')
            ->get()
            ->groupBy('yearLevel');
    }

    public function Schedule() {
        return Schedule::where('status', 1)
                   ->whereColumn('enrolled', '<', 'slots')
                   ->orderBy('courseInfoID', 'ASC')
                   ->orderBy('section', 'ASC')
                   ->get();
                   
    }

    public function getSpecificSchedule($request) {


        $student = LearnersProfile::where('id', $this->aes->decrypt($request->id))->first();

        if($student->freshmen == 1) {
            $courseInfo = CoursesInfo::where('courseID', $student->LearnersCourse->course)
            ->orderBy('yearLevel', 'ASC')
            ->orderBy('semester', 'ASC')
            ->first();

            return Schedule::where('status', 1)->where('courseInfoID', $courseInfo->id)
                   ->whereColumn('enrolled', '<', 'slots')
                   ->orderBy('courseInfoID', 'ASC')
                   ->orderBy('section', 'ASC')
                   ->get();
        }
        else {
            
            $courseInfo = CoursesInfo::where('courseID', $student->LearnersCourse->course)
            ->orderBy('yearLevel', 'ASC')
            ->orderBy('semester', 'ASC')
            ->skip($student->progress)
            ->take(1)
            ->first();

            return Schedule::where('status', 1)->where('courseInfoID', $courseInfo->id)
                   ->whereColumn('enrolled', '<', 'slots')
                   ->orderBy('courseInfoID', 'ASC')
                   ->orderBy('section', 'ASC')
                   ->get();
        }
                   
    }

    public function yearLevel($request) {
        return StudentYearLevel::where('studentID', $this->aes->decrypt($request->id))->orderBy('scheduleID', 'DESC')->get();
    }

    public function studentGrading($request) {
        return StudentGrading::where('studentID', $this->aes->decrypt($request->id))->get();
    }

    public function Graduates($request) {
        return LearnersProfile::whereHas('learnersCourse', function($query) use ($request) {
            $query->where('course', $this->aes->decrypt($request->id))
            ->where('diploma', 1);
        })->orderBy('lastname', 'ASC')
            ->get();
            
    }

    public function searchGraduates($request) {
        return LearnersProfile::whereHas('learnersCourse', function($query) use ($request) {
            $query->where('course', $this->aes->decrypt($request->id))
            ->where('diploma', 1);
        })
        ->where(function($query) use ($request) {
            $query->where('lastname', 'LIKE', '%'.$request->search.'%')
                  ->orWhere('firstname', 'LIKE', '%'.$request->search.'%')
                  ->orWhere('middlename', 'LIKE', '%'.$request->search.'%');
        })
        ->orderBy('lastname', 'ASC')
            ->get();
            
    }

    public function Undergraduates($request) {
        return LearnersProfile::whereHas('learnersCourse', function($query) use ($request) {
            $query->where('course', $this->aes->decrypt($request->id))
            ->where('diploma', null)
            ->where('freshmen', 0)
            ->where('yearLevel', '!=', null);
        })->orderBy('lastname', 'ASC')
            ->get();
            
    }

    public function searchUndergraduates($request) {
        return LearnersProfile::whereHas('learnersCourse', function($query) use ($request) {
            $query->where('course', $this->aes->decrypt($request->id))
            ->where('diploma', null)
            ->where('freshmen', 0)
            ->where('yearLevel', '!=', null);
        })
        ->where(function($query) use ($request) {
            $query->where('lastname', 'LIKE', '%'.$request->search.'%')
                  ->orWhere('firstname', 'LIKE', '%'.$request->search.'%')
                  ->orWhere('middlename', 'LIKE', '%'.$request->search.'%');
        })
        ->orderBy('lastname', 'ASC')
            ->get();
            
    }

    public function ViewAttendance($request) {
        return LearnersProfile::whereHas('learnersCourse', function($query) use ($request) {
            $query->where('course', $this->aes->decrypt($request->id))
            ->where('diploma', null)
            ->where('freshmen', 0)
            ->where('yearLevel', '!=', null);
        })->orderBy('yearLevel', 'ASC')
            ->orderBy('lastname', 'ASC')
            ->get()
            ->groupBy('yearLevel');
    }

    public function searchViewAttendance($request) {
        return LearnersProfile::whereHas('learnersCourse', function($query) use ($request) {
            $query->where('course', $this->aes->decrypt($request->id))
            ->where('diploma', null)
            ->where('freshmen', 0)
            ->where('yearLevel', '!=', null);
        })
        
        ->where(function($query) use ($request) {
            $query->where('lastname', 'LIKE', '%'.$request->search.'%')
                  ->orWhere('firstname', 'LIKE', '%'.$request->search.'%')
                  ->orWhere('middlename', 'LIKE', '%'.$request->search.'%')
                  ->orWhere('RFID', 'LIKE', '%'.$request->search.'%');
        })

        ->orderBy('yearLevel', 'ASC')
            ->orderBy('semester', 'ASC')
            ->orderBy('lastname', 'ASC')
            ->get()
            ->groupBy('yearLevel');
    }

    public function RFIDAttendance($request) {
        return RFIDAttendance::where('studentID', $this->aes->decrypt($request->id))
        ->orderBy('created_at', 'DESC')
        ->get()
        ->groupBy('yearLevel');
    }

}



?>