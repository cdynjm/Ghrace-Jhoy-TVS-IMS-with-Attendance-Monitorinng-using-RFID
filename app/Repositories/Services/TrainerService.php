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

use App\Repositories\Interfaces\TrainerInterface;

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
use App\Models\SubjectSchedule;
use App\Models\StudentYearLevel;

class TrainerService implements TrainerInterface {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(
        protected AESCipher $aes
    ) {}

    public function Schedule() {
        return SubjectSchedule::where('status', 1)->where('instructor', Auth::user()->Instructor->id)->get();
    }

    public function getSchedule($request) {
        return SubjectSchedule::where('status', 1)
        ->where('instructor', Auth::user()->Instructor->id)
        ->where('id', $this->aes->decrypt($request->id))->first();
    }

    public function Students($request) {
        return StudentYearLevel::where('scheduleID', $this->aes->decrypt($request->scheduleID))
            ->whereHas('Student', function($query) {
                $query->where('diploma', null); // Add condition to filter LearnersProfile where diploma == 0
            })
            ->with(['Student' => function($query) {
                $query->where('diploma', null); // Ensure eager loaded Student has diploma == 0
            }])
            ->orderBy(
                LearnersProfile::select('lastname')
                    ->whereColumn('learners_profile.id', 'student_year_level.studentID')
                    ->where('diploma', null), // Order by Student's lastname where diploma == 0
                'ASC'
            )
            ->get();
    }
    
    
    
}

?>