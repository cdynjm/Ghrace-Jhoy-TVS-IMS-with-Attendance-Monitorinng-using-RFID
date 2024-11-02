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

use App\Repositories\Interfaces\StudentInterface;

use App\Models\Barangay;
use App\Models\Logs;
use App\Models\Municipal;
use App\Models\Province;
use App\Modes\Region;
use App\Models\User;
use App\Models\Courses;

use App\Models\SubjectSchedule;
use App\Models\StudentYearLevel;
use App\Models\StudentGrading;

use App\Models\DocumentsPSA;
use App\Models\DocumentsForm137;

use App\Models\LearnersClass;
use App\Models\LearnersCourse;
use App\Models\LearnersProfile;
use App\Models\LearnersWork;
use App\Models\Subjects;
use App\Models\CoursesInfo;

use App\Models\Tracker;

use App\Models\RFIDAttendance;

class StudentService implements StudentInterface {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(
        protected AESCipher $aes
    ) {}
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function CourseInfo($request) {
        return Courses::where('id', $this->aes->decrypt($request->id))->first();
    }

    public function getCourseInfo($request) {
        return CoursesInfo::where('courseID', $this->aes->decrypt($request->id))
        ->orderBy('yearLevel', 'ASC')
        ->orderBy('semester', 'ASC')
        ->get();
    }
    public function Subjects($request) {
        return Subjects::where('courseID', $this->aes->decrypt($request->id))->get();
    }
    public function PSA() {
        return DocumentsPSA::where('studentID', Auth::user()->Student->id)->get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function Form137() {
        return DocumentsForm137::where('studentID', Auth::user()->Student->id)->get();
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function Tracker() {
        return Tracker::where('studentID', Auth::user()->Student->id)->get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function LearnersProfile() {
        return LearnersProfile::where('id', Auth::user()->Student->id)->first();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function LearnersCourse() {
        return LearnersCourse::where('studentID', Auth::user()->Student->id)->first();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function LearnersClass() {
        return LearnersClass::where('studentID', Auth::user()->Student->id)->get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function LearnersWork() {
        return LearnersWork::where('studentID', Auth::user()->Student->id)->get();
    }

    public function yearLevel() {
        return StudentYearLevel::where('studentID', Auth::user()->Student->id)
        ->orderBy('scheduleID', 'DESC')
        ->get();
    }

    public function subjectSchedule() {
        return SubjectSchedule::where('courseID', Auth::user()->Student->LearnersCourse->course)->get();
    }

    public function studentGrading() {
        return StudentGrading::where('studentID', Auth::user()->Student->id)->get();
    }

    public function RFIDAttendance() {
        return RFIDAttendance::where('studentID', Auth::user()->Student->id)
        ->orderBy('created_at', 'DESC')
        ->get()
        ->groupBy('yearLevel');
    }
}

?>