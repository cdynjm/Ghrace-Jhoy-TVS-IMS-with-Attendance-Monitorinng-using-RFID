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

use App\Http\Controllers\AESCipher;

use App\Repositories\Interfaces\AdminInterface;

use App\Models\Barangay;
use App\Models\Logs;
use App\Models\Municipal;
use App\Models\Province;
use App\Modes\Region;
use App\Models\User;
use App\Models\Courses;
use App\Models\Subjects;
use App\Models\CoursesInfo;
use App\Models\Instructors;

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

use App\Models\SubjectSchedule;

class AdminService implements AdminInterface {
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
    public function Logs() {
        return Logs::orderBy('created_at', 'DESC')->limit(10)->get();
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

    public function getCourseInfo($request) {
        return CoursesInfo::where('courseID', $this->aes->decrypt($request->id))
        ->orderBy('yearLevel', 'ASC')
        ->orderBy('semester', 'ASC')
        ->get();
    }

    public function searchCourseInfo($request) {
        $courseID = $this->aes->decrypt($request->id);

        // Search course info and related subjects
        return CoursesInfo::with('subjects')
            ->where('courseID', $courseID)
            ->where(function ($query) use ($request) {
                if ($request->has('search')) {
                    $searchTerm = $request->search;
                    // You can add more conditions if necessary
                    $query->where('yearLevel', 'LIKE', '%' . $searchTerm . '%')
                          ->orWhereHas('subjects', function($q) use ($searchTerm) {
                              $q->where('description', 'LIKE', '%' . $searchTerm . '%')
                                ->orWhere('subjectCode', 'LIKE', '%' . $searchTerm . '%');
                          });
                }
            })
            ->get();
    }

    public function Subjects($request) {
        return Subjects::where('courseID', $this->aes->decrypt($request->id))->get();
    }


    public function searchSubjects($request) {
        
        return Subjects::where('courseID', $this->aes->decrypt($request->id))
        ->where('subjectCode', 'LIKE', '%' . $request->search . '%')
        ->orWhere('description', 'LIKE', '%' . $request->search . '%')
        ->get();
    }

    public function Instructors() {
        return Instructors::get();
    }

    public function Schedule($request) {
        return Schedule::where('courseID', $this->aes->decrypt($request->id))
            ->orderBy('courseInfoID', 'ASC')
            ->where('status', 1)
            ->get();
    }

    public function SubjectSchedule($request) {
        return SubjectSchedule::where('courseID', $this->aes->decrypt($request->id))->get();
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
        })->orderBy('yearLevel', 'ASC')
        ->orderBy('lastname', 'ASC')
        ->get()
        ->groupBy('yearLevel');
            
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
        ->orderBy('yearLevel', 'ASC')
        ->orderBy('lastname', 'ASC')
        ->get()
        ->groupBy('yearLevel');
            
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

    public function LearnersProfile($request) {
        return LearnersProfile::where('id', $this->aes->decrypt($request->id))->first();
    }

    public function yearLevel($request) {
        return StudentYearLevel::where('studentID', $this->aes->decrypt($request->id))->orderBy('scheduleID', 'DESC')->get();
    }

    public function studentGrading($request) {
        return StudentGrading::where('studentID', $this->aes->decrypt($request->id))->get();
    }
}

?>