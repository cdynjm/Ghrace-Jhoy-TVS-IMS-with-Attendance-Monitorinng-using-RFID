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

use App\Repositories\Interfaces\AdminInterface;

use App\Models\Barangay;
use App\Models\Logs;
use App\Models\Municipal;
use App\Models\Province;
use App\Modes\Region;
use App\Models\User;
use App\Models\Courses;

use App\Models\DocumentsPSA;
use App\Models\DocumetsForm137;

use App\Models\LearnersClass;
use App\Models\LearnersCourse;
use App\Models\LearnersProfile;
use App\Models\LearnersWork;

use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(
        protected AESCipher $aes, 
        protected AdminInterface $AdminInterface
    ) {}
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function dashboard() {
        $logs = $this->AdminInterface->Logs();
        return view('pages.admin.dashboard', ['logs' => $logs]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function trainers() {
        return view('pages.admin.trainers');
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function courses() {
        $courses = $this->AdminInterface->Courses();
        return view('pages.admin.courses', ['courses' => $courses]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createCourse(Request $request) {

        Courses::create([
            'sector' => $request->sector,
            'qualification' => $request->qualification,
            'status' => $request->status,
            'copr' => $request->copr
        ]);

        $courses = $this->AdminInterface->Courses();
        $aes = $this->aes;
        
        return response()->json([
            'Message' => 'Course added successfully',
            'Courses' => view('data.admin.course-data', compact('courses', 'aes'))->render()
        ], Response::HTTP_OK);
        
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateCourse(Request $request) {
        $id = $this->aes->decrypt($request->id);
        Courses::where('id', $id)->update([
            'sector' => $request->sector,
            'qualification' => $request->qualification,
            'status' => $request->status,
            'copr' => $request->copr
        ]);

        $courses = $this->AdminInterface->Courses();
        $aes = $this->aes;

        return response()->json([
            'Message' => 'Course updated successfully',
            'Courses' => view('data.admin.course-data', compact('courses', 'aes'))->render()
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteCourse(Request $request) {
        $id = $this->aes->decrypt($request->id);
        Courses::where('id', $id)->delete();

        $courses = $this->AdminInterface->Courses();
        $aes = $this->aes;

        return response()->json([
            'Message' => 'Course deleted successfully',
            'Courses' => view('data.admin.course-data', compact('courses', 'aes'))->render()
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function students() {
        return view('pages.admin.students');
    }
}
