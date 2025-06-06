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
use Illuminate\Support\Facades\DB;
use DateTime;

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

use App\Models\DocumentsPSA;
use App\Models\DocumetsForm137;

use App\Models\LearnersClass;
use App\Models\LearnersCourse;
use App\Models\LearnersProfile;
use App\Models\LearnersWork;
use App\Models\AdmissionApplication;

use App\Models\Schedule;
use App\Models\SubjectSchedule;
use App\Models\SMSToken;
use App\Models\RFIDAttendance;

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

    public function updateSMSToken(Request $request) {
        SMSToken::where('id', 1)->update([
            'access_token' => $request->SMSAccessToken,
            'mobile_identity' => $request->SMSMobileIdentity
        ]);

        return response()->json(['Message' => 'SMS Token updated successfully'], Response::HTTP_OK);
    }

    public function admissionStatus(Request $request) {
        AdmissionApplication::where('id', 1)->update(['status' => $this->aes->decrypt($request->status)]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function dashboard() {
        $instructors = $this->AdminInterface->Instructors()->count();
        $courses = $this->AdminInterface->Courses()->count();
        $student = $this->AdminInterface->Students();
        $graduate = LearnersProfile::where('diploma', 1)->count();
        return view('pages.admin.dashboard', ['instructors' => $instructors, 'courses' => $courses, 'student' => $student, 'graduate' => $graduate]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function instructors() {
        $instructors = $this->AdminInterface->Instructors();
        return view('pages.admin.instructors', ['instructors' => $instructors]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createInstructor(Request $request) {

        if(Validator::make($request->all(), [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')
            ]
        ])->fails()) { 
            return response()->json(['Message' => 'Email is already taken'], Response::HTTP_INTERNAL_SERVER_ERROR);
         }

        $instructors = Instructors::create([
           'instructor' => $request->instructor,
           'address' => $request->address,
           'contactNumber' => $request->contactNumber,
           'degree' => $request->degree
        ]);

        User::create([
            'trainerID' => $instructors->id,
            'name' => $request->instructor,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 3
        ]);

        $instructors = $this->AdminInterface->Instructors();
        $aes = $this->aes;
        
        return response()->json([
            'Message' => 'Instructor added successfully',
            'Instructors' => view('data.admin.instructors-data', compact('instructors', 'aes'))->render()
        ], Response::HTTP_OK);
        
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateInstructor(Request $request) {

        $instructorID = $this->aes->decrypt($request->id);
    
        // Fetch the user associated with this instructor
        $user = User::where('trainerID', $instructorID)->first();
    
        // Validate the email, ignoring the current instructor's email
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id)
            ]
        ]);
    
        if ($validator->fails()) {
            return response()->json(['Message' => 'Email is already taken'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    
        // Update the instructor's details
        Instructors::where('id', $instructorID)->update([
            'instructor' => $request->instructor,
            'address' => $request->address,
            'contactNumber' => $request->contactNumber,
            'degree' => $request->degree
        ]);
    
        // Update the user email
        User::where('trainerID', $instructorID)->update([
            'email' => $request->email,
            'name' => $request->instructor
        ]);
    
        // If a new password is provided, update the password
        if (!empty($request->password)) {
            User::where('trainerID', $instructorID)->update([
                'password' => Hash::make($request->password)
            ]);
        }
    
        // Reload instructors list
        $instructors = $this->AdminInterface->Instructors();
        $aes = $this->aes;
    
        return response()->json([
            'Message' => 'Instructor updated successfully',
            'Instructors' => view('data.admin.instructors-data', compact('instructors', 'aes'))->render()
        ], Response::HTTP_OK);
    }
    
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteInstructor(Request $request) {

        Instructors::where('id', $this->aes->decrypt($request->id))->delete();
        User::where('trainerID', $this->aes->decrypt($request->id))->delete();

        $instructors = $this->AdminInterface->Instructors();
        $aes = $this->aes;
        
        return response()->json([
            'Message' => 'Instructor deleted successfully',
            'Instructors' => view('data.admin.instructors-data', compact('instructors', 'aes'))->render()
        ], Response::HTTP_OK);
        
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
    public function coursesInfo(Request $request) {
        $course = $this->AdminInterface->CourseInfo($request);
        $courseInfo = $this->AdminInterface->getCourseInfo($request);
        $subjects = $this->AdminInterface->Subjects($request);
        return view('pages.admin.courses-info', compact('course', 'courseInfo', 'subjects'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createCourseInfo(Request $request) {

        $get = CoursesInfo::create([
            'courseID' => $this->aes->decrypt($request->id),
            'yearLevel' => $request->year,
            'semester' => $request->semester
        ]);

        foreach($request->description as $key => $value) {
            Subjects::create([
                'courseID' => $this->aes->decrypt($request->id),
                'courseInfoID' => $get->id,
                'description' => $value,   
                'subjectCode' => $request->subjectCode[$key],                        
                'units' => $request->units[$key],
                'NC' => $request->NC[$key] ?? 0
            ]);
        }
        

        $course = $this->AdminInterface->CourseInfo($request);
        $courseInfo = $this->AdminInterface->getCourseInfo($request);
        $subjects = $this->AdminInterface->Subjects($request);
        $aes = $this->aes;
        
        return response()->json([
            'Message' => 'Course Subjects added successfully',
            'CoursesInfo' => view('data.admin.course-info-data', compact('course', 'courseInfo', 'subjects', 'aes'))->render()
        ], Response::HTTP_OK);
        
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateCourseInfo(Request $request) {

        CoursesInfo::where('id', $this->aes->decrypt($request->courseInfoID))->update([
            'yearLevel' => $request->year,
            'semester' => $request->semester
        ]);
        
        $course = CoursesInfo::where('id', $this->aes->decrypt($request->courseInfoID))->first();

        foreach($request->description as $key => $value) {
            // Check if subjectID is defined and not empty for the given key
            if (empty($request->subjectID[$key]) || !isset($request->subjectID[$key])) {
                // If subjectID is not set or empty, create a new subject
                Subjects::create([
                    'courseID' => $course->courseID,
                    'courseInfoID' => $this->aes->decrypt($request->courseInfoID),
                    'description' => $value,   
                    'subjectCode' => $request->subjectCode[$key],                        
                    'units' => $request->units[$key],
                    'NC' => $request->NC[$key] ?? 0
                ]);
            } else {
                // If subjectID is set and valid, update the existing subject
                Subjects::where('id', $this->aes->decrypt($request->subjectID[$key]))->update([
                    'description' => $value,   
                    'subjectCode' => $request->subjectCode[$key],                        
                    'units' => $request->units[$key],
                    'NC' => $request->NC[$key] ?? 0
                ]);
            }
        }
        
        
        $course = $this->AdminInterface->CourseInfo($request);
        $courseInfo = $this->AdminInterface->getCourseInfo($request);
        $subjects = $this->AdminInterface->Subjects($request);
        $aes = $this->aes;
        
        return response()->json([
            'Message' => 'Course Subjects updated successfully',
            'CoursesInfo' => view('data.admin.course-info-data', compact('course', 'courseInfo', 'subjects', 'aes'))->render()
        ], Response::HTTP_OK);
        
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function searchCourseInfo(Request $request) {
        

        $course = $this->AdminInterface->CourseInfo($request);
        $courseInfo = $this->AdminInterface->getCourseInfo($request);
        $subjects = $this->AdminInterface->searchSubjects($request);
        $aes = $this->aes;
        
        return response()->json([
            'Message' => 'Course Subjects added successfully',
            'CoursesInfo' => view('data.admin.course-info-data', compact('course', 'courseInfo', 'subjects', 'aes'))->render()
        ], Response::HTTP_OK);
        
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function schedule() {
        $courses = $this->AdminInterface->Courses();
        return view('pages.admin.schedule', ['courses' => $courses]);
    }

    public function searchSchedule(Request $request) {

        $schedule = Schedule::where('courseID', $this->aes->decrypt($request->id))
        ->where('schoolYear', $request->schoolYear)
        ->where('courseInfoID', $this->aes->decrypt($request->yearSemester))
        ->orderBy('courseInfoID', 'ASC')
        ->get();

        $subjectSchedule = $this->AdminInterface->SubjectSchedule($request);
        $aes = $this->aes;

        return response()->json([
            'schedule' => view('data.admin.schedule-subject-course-data', compact('schedule', 'subjectSchedule', 'aes'))->render()
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createSchedule(Request $request) {
        $course = $this->AdminInterface->CourseInfo($request);
        $courseInfo = $this->AdminInterface->getCourseInfo($request);
        $instructors = $this->AdminInterface->Instructors();

        $schedule = $this->AdminInterface->Schedule($request);
        $subjectSchedule = $this->AdminInterface->SubjectSchedule($request);

        $schoolYears = Schedule::select('schoolYear')->distinct()->where('courseID', $this->aes->decrypt($request->id))->get();

        return view('pages.admin.create-schedule', compact('course', 'courseInfo', 'instructors', 'schedule', 'subjectSchedule', 'schoolYears'));
    }

    public function getSubjects(Request $request){

        $subjects = Subjects::where('courseInfoID', $this->aes->decrypt($request->id))->get();
        $instructors = $this->AdminInterface->Instructors();
        $aes = $this->aes;

        return response()->json([
            'Subjects' => view('modals.admin.create.subjects.subject-list', compact('subjects', 'instructors', 'aes'))->render()
        ], Response::HTTP_OK);
    }

    public function createSubjectSchedule(Request $request) {

        $conflicts = []; // Array to hold conflicting schedules
        $schedThatConflicts = [];
        $data = false;

        foreach (SubjectSchedule::where('status', 1)->get() as $sc) {
            foreach ($request->subjectID as $key => $subjectID) {
                if(!empty($request->room[$key]) && !empty($request->fromTime[$key]) && !empty($request->toTime[$key])) {
                    if (
                        // no conflict with same instructor, same schedule (day and time) with same room and same subject
                        (
                            $sc->instructor == $this->aes->decrypt($request->instructor[$key]) &&
                            !(
                                Carbon::createFromFormat('H:i', $request->fromTime[$key])->addMinute()->format('H:i') >= $sc->toTime ||  // New start time is after existing end time
                                $request->toTime[$key] <= $sc->fromTime     // New end time is before existing start time
                            ) &&
                            (
                                (isset($request->days[$key][0]) && $request->days[$key][0] == $sc->mon) ||
                                (isset($request->days[$key][1]) && $request->days[$key][1] == $sc->tue) ||
                                (isset($request->days[$key][2]) && $request->days[$key][2] == $sc->wed) ||
                                (isset($request->days[$key][3]) && $request->days[$key][3] == $sc->thu) ||
                                (isset($request->days[$key][4]) && $request->days[$key][4] == $sc->fri) ||
                                (isset($request->days[$key][5]) && $request->days[$key][5] == $sc->sat)
                            ) &&
                            $request->room[$key] == $sc->room &&
                            $subjectID == $sc->subject
                        )
                        ||
                        // no conflict with same instructor, same schedule (day and time) with same room and diff subject
                        (
                            $sc->instructor == $this->aes->decrypt($request->instructor[$key]) &&
                            !(
                                Carbon::createFromFormat('H:i', $request->fromTime[$key])->addMinute()->format('H:i') >= $sc->toTime ||  // New start time is after existing end time
                                $request->toTime[$key] <= $sc->fromTime     // New end time is before existing start time
                            ) &&
                            (
                                (isset($request->days[$key][0]) && $request->days[$key][0] == $sc->mon) ||
                                (isset($request->days[$key][1]) && $request->days[$key][1] == $sc->tue) ||
                                (isset($request->days[$key][2]) && $request->days[$key][2] == $sc->wed) ||
                                (isset($request->days[$key][3]) && $request->days[$key][3] == $sc->thu) ||
                                (isset($request->days[$key][4]) && $request->days[$key][4] == $sc->fri) ||
                                (isset($request->days[$key][5]) && $request->days[$key][5] == $sc->sat)
                            ) &&
                        
                            $request->room[$key] == $sc->room &&
                            $subjectID != $sc->subject
                        )
                        ||
                        // no conflict with same instructor, same schedule (day and time) with diff room and diff  subject
                        (
                            $sc->instructor == $this->aes->decrypt($request->instructor[$key]) &&
                            !(
                                Carbon::createFromFormat('H:i', $request->fromTime[$key])->addMinute()->format('H:i') >= $sc->toTime ||  // New start time is after existing end time
                                $request->toTime[$key] <= $sc->fromTime     // New end time is before existing start time
                            ) &&
                            (
                                (isset($request->days[$key][0]) && $request->days[$key][0] == $sc->mon) ||
                                (isset($request->days[$key][1]) && $request->days[$key][1] == $sc->tue) ||
                                (isset($request->days[$key][2]) && $request->days[$key][2] == $sc->wed) ||
                                (isset($request->days[$key][3]) && $request->days[$key][3] == $sc->thu) ||
                                (isset($request->days[$key][4]) && $request->days[$key][4] == $sc->fri) ||
                                (isset($request->days[$key][5]) && $request->days[$key][5] == $sc->sat)
                            ) &&
                            $request->room[$key] != $sc->room &&
                            $subjectID != $sc->subject
                        )
                        ||
                        // no conflict with same instructor, same schedule (day and time) with diff room and diff  subject
                        (
                            $sc->instructor == $this->aes->decrypt($request->instructor[$key]) &&
                            !(
                                Carbon::createFromFormat('H:i', $request->fromTime[$key])->addMinute()->format('H:i') >= $sc->toTime ||  // New start time is after existing end time
                                $request->toTime[$key] <= $sc->fromTime     // New end time is before existing start time
                            ) &&
                            (
                                (isset($request->days[$key][0]) && $request->days[$key][0] == $sc->mon) ||
                                (isset($request->days[$key][1]) && $request->days[$key][1] == $sc->tue) ||
                                (isset($request->days[$key][2]) && $request->days[$key][2] == $sc->wed) ||
                                (isset($request->days[$key][3]) && $request->days[$key][3] == $sc->thu) ||
                                (isset($request->days[$key][4]) && $request->days[$key][4] == $sc->fri) ||
                                (isset($request->days[$key][5]) && $request->days[$key][5] == $sc->sat)
                            ) &&
                            $request->room[$key] != $sc->room &&
                            $subjectID == $sc->subject
                        )
                        ||
                        // no conflict with diff instructor, same schedule (day and time) with same room and same subject
                        (
                            $sc->instructor != $this->aes->decrypt($request->instructor[$key]) &&
                            !(
                                Carbon::createFromFormat('H:i', $request->fromTime[$key])->addMinute()->format('H:i') >= $sc->toTime ||  // New start time is after existing end time
                                $request->toTime[$key] <= $sc->fromTime     // New end time is before existing start time
                            ) &&
                            (
                                (isset($request->days[$key][0]) && $request->days[$key][0] == $sc->mon) ||
                                (isset($request->days[$key][1]) && $request->days[$key][1] == $sc->tue) ||
                                (isset($request->days[$key][2]) && $request->days[$key][2] == $sc->wed) ||
                                (isset($request->days[$key][3]) && $request->days[$key][3] == $sc->thu) ||
                                (isset($request->days[$key][4]) && $request->days[$key][4] == $sc->fri) ||
                                (isset($request->days[$key][5]) && $request->days[$key][5] == $sc->sat)
                            ) &&
                            $request->room[$key] == $sc->room &&
                            $subjectID == $sc->subject
                        )
                        ||
                        // no conflict with diff instructor, same schedule (day and time) with same room and diff subject
                        (
                            $sc->instructor != $this->aes->decrypt($request->instructor[$key]) &&
                            !(
                                Carbon::createFromFormat('H:i', $request->fromTime[$key])->addMinute()->format('H:i') >= $sc->toTime ||  // New start time is after existing end time
                                $request->toTime[$key] <= $sc->fromTime     // New end time is before existing start time
                            ) &&
                            (
                                (isset($request->days[$key][0]) && $request->days[$key][0] == $sc->mon) ||
                                (isset($request->days[$key][1]) && $request->days[$key][1] == $sc->tue) ||
                                (isset($request->days[$key][2]) && $request->days[$key][2] == $sc->wed) ||
                                (isset($request->days[$key][3]) && $request->days[$key][3] == $sc->thu) ||
                                (isset($request->days[$key][4]) && $request->days[$key][4] == $sc->fri) ||
                                (isset($request->days[$key][5]) && $request->days[$key][5] == $sc->sat)
                            ) &&
                            $request->room[$key] == $sc->room &&
                            $subjectID != $sc->subject
                        )
                        
                    ) {
                        // Add the conflicting schedule details to the conflicts array
                        $conflicts[] = [
                            'instructor' => $sc->Instructors->instructor,
                            'subject' => $sc->Subjects->description,
                            'room' => $sc->room,
                            'days' => [
                                'mon' => $sc->mon,
                                'tue' => $sc->tue,
                                'wed' => $sc->wed,
                                'thu' => $sc->thu,
                                'fri' => $sc->fri,
                                'sat' => $sc->sat,
                            ],
                            'fromTime' => date('h:i A', strtotime($sc->fromTime)),
                            'toTime' => date('h:i A', strtotime($sc->toTime)),
                        ];

                        $schedThatConflicts[] = [
                            'instructor' => Instructors::where('id', $this->aes->decrypt($request->instructor[$key]))->first()->instructor,
                            'subject' => Subjects::where('id', $subjectID)->first()->description,
                            'room' => $request->room[$key],
                            'days' => [
                                'mon' => $request->days[$key][0] ?? 0,
                                'tue' => $request->days[$key][1] ?? 0,
                                'wed' => $request->days[$key][2] ?? 0,
                                'thu' => $request->days[$key][3] ?? 0,
                                'fri' => $request->days[$key][4] ?? 0,
                                'sat' => $request->days[$key][5] ?? 0,
                            ],
                            'fromTime' => date('h:i A', strtotime($request->fromTime[$key])),
                            'toTime' => date('h:i A', strtotime($request->toTime[$key])),
                        ];

                        $data = true;
                    }
                }
            }
        }

        if($data == true) {
            return response()->json([
                'Message' => 'Conflicts detected with existing schedules', // A generic message or change according to your needs
                'Conflicts' => $conflicts, // Include the actual conflict data
                'schedThatConflicts' => $schedThatConflicts
            ], 500);
        }

        $schedule = Schedule::create([
            'courseID' => $this->aes->decrypt($request->id),
            'courseInfoID' => $this->aes->decrypt($request->yearLevel),
            'section' => $request->section,
            'slots' => $request->slots,
            'enrolled' => 0,
            'status' => 1, 
            'schoolYear' => $request->schoolYear
        ]);

        foreach ($request->subjectID as $key => $subjectID) {
            SubjectSchedule::create([
                'courseID' => $this->aes->decrypt($request->id),
                'courseInfoID' => $this->aes->decrypt($request->yearLevel),
                'scheduleID' => $schedule->id,
                'subject' => $subjectID,
                'instructor' => $this->aes->decrypt($request->instructor[$key]),
                'room' => $request->room[$key],
                'mon' => $request->days[$key][0] ?? 0,
                'tue' => $request->days[$key][1] ?? 0,
                'wed' => $request->days[$key][2] ?? 0,
                'thu' => $request->days[$key][3] ?? 0,
                'fri' => $request->days[$key][4] ?? 0,
                'sat' => $request->days[$key][5] ?? 0,
                'fromTime' => $request->fromTime[$key],
                'toTime' => $request->toTime[$key],
                'status' => 1
            ]);
        }
        
        $courseInfo = $this->AdminInterface->getCourseInfo($request);
        $instructors = $this->AdminInterface->Instructors();

        $schedule = $this->AdminInterface->Schedule($request);
        $subjectSchedule = $this->AdminInterface->SubjectSchedule($request);
        $aes = $this->aes;

        return response()->json([
            'Message' => 'Schedule created successfully',
            'Schedule' =>  view('data.admin.schedule-subject-course-data', compact('aes', 'courseInfo', 'instructors', 'schedule', 'subjectSchedule'))->render(),
        ], Response::HTTP_OK);
    }
    
    

    public function getSubjectSchedule(Request $request){

        $subjects = SubjectSchedule::where('scheduleID', $this->aes->decrypt($request->id))->get();
        $instructors = $this->AdminInterface->Instructors();
        $aes = $this->aes;

        return response()->json([
            'Subjects' => view('modals.admin.update.subjects.subject-list', compact('subjects', 'instructors', 'aes'))->render()
        ], Response::HTTP_OK);
    }

    public function updateSubjectSchedule(Request $request) {

        $conflicts = []; // Array to hold conflicting schedules
        $schedThatConflicts = [];
        $data = false;
      
            foreach ($request->subjectID as $key => $subjectID) {
                foreach (SubjectSchedule::where('status', 1)->where('id', '!=', $this->aes->decrypt($request->subjectID[$key]))->get() as $sc) {
                if(!empty($request->room[$key]) && !empty($request->fromTime[$key]) && !empty($request->toTime[$key])) {
                    if (
                        // no conflict with same instructor, same schedule (day and time) with same room and same subject
                        (
                            $sc->instructor == $this->aes->decrypt($request->instructor[$key]) &&
                            !(
                                (new DateTime($request->fromTime[$key]))->modify('+1 minute')->format('H:i') >= $sc->toTime ||  // New start time is after existing end time                                // New start time is after existing end time
                                $request->toTime[$key] <= $sc->fromTime     // New end time is before existing start time
                            ) &&
                            (
                                (isset($request->days[$key][0]) && $request->days[$key][0] == $sc->mon) ||
                                (isset($request->days[$key][1]) && $request->days[$key][1] == $sc->tue) ||
                                (isset($request->days[$key][2]) && $request->days[$key][2] == $sc->wed) ||
                                (isset($request->days[$key][3]) && $request->days[$key][3] == $sc->thu) ||
                                (isset($request->days[$key][4]) && $request->days[$key][4] == $sc->fri) ||
                                (isset($request->days[$key][5]) && $request->days[$key][5] == $sc->sat)
                            ) &&
                            $request->room[$key] == $sc->room &&
                            $this->aes->decrypt($subjectID) == $sc->subject
                        )
                        ||
                        // no conflict with same instructor, same schedule (day and time) with same room and diff subject
                        (
                            $sc->instructor == $this->aes->decrypt($request->instructor[$key]) &&
                            !(
                                (new DateTime($request->fromTime[$key]))->modify('+1 minute')->format('H:i') >= $sc->toTime ||
                                $request->toTime[$key] <= $sc->fromTime     // New end time is before existing start time
                            ) &&
                            (
                                (isset($request->days[$key][0]) && $request->days[$key][0] == $sc->mon) ||
                                (isset($request->days[$key][1]) && $request->days[$key][1] == $sc->tue) ||
                                (isset($request->days[$key][2]) && $request->days[$key][2] == $sc->wed) ||
                                (isset($request->days[$key][3]) && $request->days[$key][3] == $sc->thu) ||
                                (isset($request->days[$key][4]) && $request->days[$key][4] == $sc->fri) ||
                                (isset($request->days[$key][5]) && $request->days[$key][5] == $sc->sat)
                            ) &&
                        
                            $request->room[$key] == $sc->room &&
                            $this->aes->decrypt($subjectID) != $sc->subject
                        )
                        ||
                        // no conflict with same instructor, same schedule (day and time) with diff room and diff  subject
                        (
                            $sc->instructor == $this->aes->decrypt($request->instructor[$key]) &&
                            !(
                                (new DateTime($request->fromTime[$key]))->modify('+1 minute')->format('H:i') >= $sc->toTime ||  // New start time is after existing end time
                                $request->toTime[$key] <= $sc->fromTime     // New end time is before existing start time
                            ) &&
                            (
                                (isset($request->days[$key][0]) && $request->days[$key][0] == $sc->mon) ||
                                (isset($request->days[$key][1]) && $request->days[$key][1] == $sc->tue) ||
                                (isset($request->days[$key][2]) && $request->days[$key][2] == $sc->wed) ||
                                (isset($request->days[$key][3]) && $request->days[$key][3] == $sc->thu) ||
                                (isset($request->days[$key][4]) && $request->days[$key][4] == $sc->fri) ||
                                (isset($request->days[$key][5]) && $request->days[$key][5] == $sc->sat)
                            ) &&
                            $request->room[$key] != $sc->room &&
                            $this->aes->decrypt($subjectID) != $sc->subject
                        )
                        ||
                        // no conflict with same instructor, same schedule (day and time) with diff room and diff  subject
                        (
                            $sc->instructor == $this->aes->decrypt($request->instructor[$key]) &&
                            !(
                                (new DateTime($request->fromTime[$key]))->modify('+1 minute')->format('H:i') >= $sc->toTime ||  // New start time is after existing end time
                                $request->toTime[$key] <= $sc->fromTime     // New end time is before existing start time
                            ) &&
                            (
                                (isset($request->days[$key][0]) && $request->days[$key][0] == $sc->mon) ||
                                (isset($request->days[$key][1]) && $request->days[$key][1] == $sc->tue) ||
                                (isset($request->days[$key][2]) && $request->days[$key][2] == $sc->wed) ||
                                (isset($request->days[$key][3]) && $request->days[$key][3] == $sc->thu) ||
                                (isset($request->days[$key][4]) && $request->days[$key][4] == $sc->fri) ||
                                (isset($request->days[$key][5]) && $request->days[$key][5] == $sc->sat)
                            ) &&
                            $request->room[$key] != $sc->room &&
                            $this->aes->decrypt($subjectID) == $sc->subject
                        )
                        ||
                        // no conflict with diff instructor, same schedule (day and time) with same room and same subject
                        (
                            $sc->instructor != $this->aes->decrypt($request->instructor[$key]) &&
                            !(
                                (new DateTime($request->fromTime[$key]))->modify('+1 minute')->format('H:i') >= $sc->toTime ||  // New start time is after existing end time
                                $request->toTime[$key] <= $sc->fromTime     // New end time is before existing start time
                            ) &&
                            (
                                (isset($request->days[$key][0]) && $request->days[$key][0] == $sc->mon) ||
                                (isset($request->days[$key][1]) && $request->days[$key][1] == $sc->tue) ||
                                (isset($request->days[$key][2]) && $request->days[$key][2] == $sc->wed) ||
                                (isset($request->days[$key][3]) && $request->days[$key][3] == $sc->thu) ||
                                (isset($request->days[$key][4]) && $request->days[$key][4] == $sc->fri) ||
                                (isset($request->days[$key][5]) && $request->days[$key][5] == $sc->sat)
                            ) &&
                            $request->room[$key] == $sc->room &&
                            $this->aes->decrypt($subjectID) == $sc->subject
                        )
                        ||
                        // no conflict with diff instructor, same schedule (day and time) with same room and diff subject
                        (
                            $sc->instructor != $this->aes->decrypt($request->instructor[$key]) &&
                            !(
                                (new DateTime($request->fromTime[$key]))->modify('+1 minute')->format('H:i') >= $sc->toTime ||  // New start time is after existing end time
                                $request->toTime[$key] <= $sc->fromTime     // New end time is before existing start time
                            ) &&
                            (
                                (isset($request->days[$key][0]) && $request->days[$key][0] == $sc->mon) ||
                                (isset($request->days[$key][1]) && $request->days[$key][1] == $sc->tue) ||
                                (isset($request->days[$key][2]) && $request->days[$key][2] == $sc->wed) ||
                                (isset($request->days[$key][3]) && $request->days[$key][3] == $sc->thu) ||
                                (isset($request->days[$key][4]) && $request->days[$key][4] == $sc->fri) ||
                                (isset($request->days[$key][5]) && $request->days[$key][5] == $sc->sat)
                            ) &&
                            $request->room[$key] == $sc->room &&
                            $this->aes->decrypt($subjectID) != $sc->subject
                        )
                        
                    ) {
                        // Add the conflicting schedule details to the conflicts array
                        $conflicts[] = [
                            'instructor' => $sc->Instructors->instructor,
                            'subject' => $sc->Subjects->description,
                            'room' => $sc->room,
                            'days' => [
                                'mon' => $sc->mon,
                                'tue' => $sc->tue,
                                'wed' => $sc->wed,
                                'thu' => $sc->thu,
                                'fri' => $sc->fri,
                                'sat' => $sc->sat,
                            ],
                            'fromTime' => date('h:i A', strtotime($sc->fromTime)),
                            'toTime' => date('h:i A', strtotime($sc->toTime)),
                        ];

                        $schedThatConflicts[] = [
                            'instructor' => Instructors::where('id', $this->aes->decrypt($request->instructor[$key]))->first()->instructor,
                            'subject' => Subjects::where('id', $this->aes->decrypt($request->subject[$key]))->first()->description,
                            'room' => $request->room[$key],
                            'days' => [
                                'mon' => $request->days[$key][0] ?? 0,
                                'tue' => $request->days[$key][1] ?? 0,
                                'wed' => $request->days[$key][2] ?? 0,
                                'thu' => $request->days[$key][3] ?? 0,
                                'fri' => $request->days[$key][4] ?? 0,
                                'sat' => $request->days[$key][5] ?? 0,
                            ],
                            'fromTime' => date('h:i A', strtotime($request->fromTime[$key])),
                            'toTime' => date('h:i A', strtotime($request->toTime[$key])),
                        ];

                        $data = true;
                    }
                }
            }
        }

        if($data == true) {
             return response()->json([
                'Message' => 'Conflicts detected with existing schedules', // A generic message or change according to your needs
                'Conflicts' => $conflicts, // Include the actual conflict data
                'schedThatConflicts' => $schedThatConflicts
            ], 500);
        }

       $schedule = Schedule::where('id', $this->aes->decrypt($request->scheduleID))->update([
           'section' => $request->section,
           'slots' => $request->slots,
           'schoolYear' => $request->schoolYear
       ]);

       foreach ($request->subjectID as $key => $subjectID) {
           SubjectSchedule::where('id', $this->aes->decrypt($request->subjectID[$key]))->update([
               'instructor' => $this->aes->decrypt($request->instructor[$key]),
               'room' => $request->room[$key],
               'mon' => $request->days[$key][0] ?? 0,
               'tue' => $request->days[$key][1] ?? 0,
               'wed' => $request->days[$key][2] ?? 0,
               'thu' => $request->days[$key][3] ?? 0,
               'fri' => $request->days[$key][4] ?? 0,
               'sat' => $request->days[$key][5] ?? 0,
               'fromTime' => $request->fromTime[$key],
               'toTime' => $request->toTime[$key],
               'status' => 1
           ]);
       }
       
       $courseInfo = $this->AdminInterface->getCourseInfo($request);
       $instructors = $this->AdminInterface->Instructors();

       $schedule = $this->AdminInterface->Schedule($request);
       $subjectSchedule = $this->AdminInterface->SubjectSchedule($request);
       $aes = $this->aes;

       return response()->json([
           'Message' => 'Schedule updated successfully',
           'Schedule' =>  view('data.admin.schedule-subject-course-data', compact('aes', 'courseInfo', 'instructors', 'schedule', 'subjectSchedule'))->render()
       ], Response::HTTP_OK);

   }

   public function archiveSubjectSchedule(Request $request) {

    Schedule::where('id', $this->aes->decrypt($request->scheduleID))->update([
        'status' => 0
    ]);
    
    SubjectSchedule::where('scheduleID', $this->aes->decrypt($request->scheduleID))->update([
        'status' => 0
    ]);

    $courseInfo = $this->AdminInterface->getCourseInfo($request);
    $instructors = $this->AdminInterface->Instructors();

    $schedule = $this->AdminInterface->Schedule($request);
    $subjectSchedule = $this->AdminInterface->SubjectSchedule($request);
    $aes = $this->aes;

    return response()->json([
        'Message' => 'Schedule archived successfully',
        'Schedule' =>  view('data.admin.schedule-subject-course-data', compact('aes', 'courseInfo', 'instructors', 'schedule', 'subjectSchedule'))->render()
    ], Response::HTTP_OK);

    }

    public function getCourseInfoSubject(Request $request) {

        $subjects = Subjects::where('courseInfoID', $this->aes->decrypt($request->courseInfoID))->get();
        $aes = $this->aes;

        return response()->json([
            'Subjects' => view('modals.admin.update.subjects.course-subject-list', compact('subjects', 'aes'))->render()
        ], Response::HTTP_OK);
    }

    public function graduates() {
        $courses = $this->AdminInterface->Courses();
        return view('pages.admin.graduates', ['courses' => $courses]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function undergraduates() {
        $courses = $this->AdminInterface->Courses();
        return view('pages.admin.undergraduates', ['courses' => $courses]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function attendance() {
        $courses = $this->AdminInterface->Courses();
        return view('pages.admin.attendance', ['courses' => $courses]);
    }
    public function searchGraduates(Request $request) {

        $course = $this->AdminInterface->CourseInfo($request);
        $graduates = $this->AdminInterface->searchGraduates($request);
        $aes = $this->aes;
        
        return response()->json([
            'Search' => view('data.admin.view-graduates-data', compact('graduates', 'aes', 'course'))->render(),
        ], Response::HTTP_OK); 
    }

    public function searchUndergraduates(Request $request) {

        $course = $this->AdminInterface->CourseInfo($request);
        $undergraduates = $this->AdminInterface->searchUndergraduates($request);
        $aes = $this->aes;
        
        return response()->json([
            'Search' => view('data.admin.view-undergraduates-data', compact('undergraduates', 'aes', 'course'))->render(),
        ], Response::HTTP_OK); 
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function viewGraduates(Request $request) {
        $course = $this->AdminInterface->CourseInfo($request);
        $graduates = $this->AdminInterface->Graduates($request);
        return view('pages.admin.view-graduates', compact('graduates', 'course'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function viewUndergraduates(Request $request) {
        $course = $this->AdminInterface->CourseInfo($request);
        $undergraduates = $this->AdminInterface->Undergraduates($request);
        return view('pages.admin.view-undergraduates', compact('undergraduates', 'course'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function viewAttendance(Request $request) {
        $course = $this->AdminInterface->CourseInfo($request);
        $attendance = $this->AdminInterface->ViewAttendance($request);
        return view('pages.admin.view-attendance', compact('attendance', 'course'));
    }
    public function searchViewAttendance(Request $request) {

        $course = $this->AdminInterface->CourseInfo($request);
        $attendance = $this->AdminInterface->searchViewAttendance($request);
        $aes = $this->aes;
        
        return response()->json([
            'Search' => view('data.admin.view-attendance-data', compact('attendance', 'aes', 'course'))->render(),
        ], Response::HTTP_OK); 
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function viewStudentAttendance(Request $request) {
        $attendance = $this->AdminInterface->RFIDAttendance($request);
        $student = $this->AdminInterface->LearnersProfile($request);
        return view('pages.admin.view-student-attendance', compact('attendance', 'student'));
    }

    public function editGrades(Request $request) {

        $yearLevel = $this->AdminInterface->yearLevel($request);
        $studentGrading = $this->AdminInterface->studentGrading($request);
        $student = $this->AdminInterface->LearnersProfile($request);
        return view('pages.admin.edit-grades', compact('yearLevel', 'studentGrading', 'student'));
    }

    public function searchStudentAttendance(Request $request) {
        $attendance = RFIDAttendance::where('studentID', $this->aes->decrypt($request->id))
        ->where('yearLevel', $request->yearLevel)
        ->where('month', $request->month)
        ->orderBy('created_at', 'DESC')
        ->get()
        ->groupBy('yearLevel');

        $aes = $this->aes;
        return response()->json([
            'Attendance' => view('data.admin.view-student-attendance-data', compact('attendance', 'aes'))->render()
        ]);
    }
}