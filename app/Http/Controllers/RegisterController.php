<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

use Session;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;

use App\Http\Controllers\AESCipher;

use App\Repositories\Interfaces\RegistrationInterface;

use App\Models\Barangay;
use App\Models\Logs;
use App\Models\Municipal;
use App\Models\Province;
use App\Models\Region;
use App\Models\User;
use App\Models\Courses;

use App\Models\LearnersClass;
use App\Models\LearnersCourse;
use App\Models\LearnersProfile;
use App\Models\LearnersWork;
use App\Models\AdmissionApplication;

use App\Models\Tracker;

class RegisterController extends Controller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(
        protected AESCipher $aes,
        protected RegistrationInterface $RegistrationInterface
    ) {}
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function register(Request $request) {
        if(AdmissionApplication::where('id', 1)->first()->status == 1) {
            $region = $this->RegistrationInterface->Region();
            $courses = $this->RegistrationInterface->Courses();
            return view('auth.register', compact('region', 'courses'));
        }
        else {
            abort(401);
        }
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function Province(Request $request) {
        $province = $this->RegistrationInterface->Province($request);
        $aes = $this->aes;
        return response()->json([
            'Province' => view('auth.address.province', compact('aes', 'province'))->render()
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function Municipal(Request $request) {
        $municipal = $this->RegistrationInterface->Municipal($request);
        $aes = $this->aes;
        return response()->json([
            'Municipal' => view('auth.address.municipal', compact('aes', 'municipal'))->render()
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function Barangay(Request $request) {
        $barangay = $this->RegistrationInterface->Barangay($request);
        $aes = $this->aes;
        return response()->json([
            'Barangay' => view('auth.address.barangay', compact('aes', 'barangay'))->render()
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function BirthplaceProvince(Request $request) {
        $province = $this->RegistrationInterface->BirthplaceProvince($request);
        $aes = $this->aes;
        return response()->json([
            'Province' => view('auth.birthplace.province', compact('aes', 'province'))->render()
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function BirthplaceMunicipal(Request $request) {
        $municipal = $this->RegistrationInterface->BirthplaceMunicipal($request);
        $aes = $this->aes;
        return response()->json([
            'Municipal' => view('auth.birthplace.municipal', compact('aes', 'municipal'))->render()
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function AdmissionApplication(Request $request) {

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

        $region = $this->aes->decrypt($request->region);
        $province = $this->aes->decrypt($request->province);
        $municipal = $this->aes->decrypt($request->municipal);
        $barangay = $this->aes->decrypt($request->barangay);

        $birthplaceRegion = $this->aes->decrypt($request->birthplaceRegion);
        $birthplaceProvince = $this->aes->decrypt($request->birthplaceProvince);
        $birthplaceMunicipal = $this->aes->decrypt($request->birthplaceMunicipal);

        $course = $this->aes->decrypt($request->course);

        $student = LearnersProfile::create([
            'lastname' => $request->lastname . ($request->extension ? ', ' . $request->extension : ''),
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'region' => $region,
            'province' => $province,
            'city' => $municipal,
            'barangay' => $barangay,
            'district' => $request->district,
            'street' => $request->street,
            'account' => $request->account,
            'phone' => $request->phone,
            'nationality' => $request->nationality,
            'sex' => $request->sex,
            'civilStatus' => $request->civilStatus,
            'employmentStatus' => $request->employmentStatus,
            'employmentType' => $request->employmentType,
            'birthdate' => $request->birthdate,
            'age' => $request->age,
            'birthplaceRegion' => $birthplaceRegion,
            'birthplaceProvince' => $birthplaceProvince,
            'birthplaceCity' => $birthplaceMunicipal,
            'education' => $request->education,
            'parent' => $request->parent,
            'parentContact' => $request->parentContact,
            'parentAddress' => $request->parentAddress,
            'consent' => $request->consent,
            'dateAccomplished' => Carbon::now(),
            'admission_status' => 1,
            'status' => 1,
        ]);

        if(!empty($request->classOne)) {
            foreach($request->classOne as $key => $value) {
                LearnersClass::create([
                    'studentID' => $student->id,
                    'classification' => $value, 
                ]);
            }
        }

        if(!empty($request->classTwo)) {
            foreach($request->classTwo as $key => $value) {
                LearnersClass::create([
                    'studentID' => $student->id,
                    'classification' => $value, 
                ]);
            }
        }

        if(!empty($request->classThree)) {
            foreach($request->classThree as $key => $value) {
                if($value == 24) {
                    LearnersClass::create([
                        'studentID' => $student->id,
                        'classification' => $value,
                        'others' => $request->others
                    ]);
                }
                else {
                    LearnersClass::create([
                        'studentID' => $student->id,
                        'classification' => $value,
                    ]);
                }
            }
        }

        LearnersCourse::create([
            'studentID' => $student->id,
            'course' => $course,
            'scholarship' => $request->scholarship,  
        ]);

        if(!empty($request->company)) {
            foreach($request->company as $key => $value) {
                if(!empty($value)) {
                    LearnersWork::create([
                        'studentID' => $student->id,
                        'company' => $request->company[$key],
                        'position' => $request->position[$key],
                        'dateFrom' => $request->dateFrom[$key],
                        'dateTo' => $request->dateTo[$key],
                        'salary' => $request->salary[$key],
                        'status' => $request->status[$key],
                    ]);
                }
            }
        }

        Tracker::create([
            'studentID' => $student->id,
            'tracker' => 1
        ]);

        $user = User::create([
            'studentID' => $student->id,
            'name' => $student->firstname." ".$student->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 4
        ]);
        
        $loginUser = User::where('id', $user->id)->first();

        Auth::login($loginUser);

        event(new Registered($user));

        $loginUser->update(['email_verification_sent_at' => now()]);

        return response()->json([
            'Message' => 'Submission Successful. To open your account, please log in using the email address and password you provided. We have also sent an EMAIL VERIFICATION to your email, please check and verify your email to proceed accordingly after logged in.',
            'Redirect' => '/student/dashboard'
        ], Response::HTTP_OK);
    }
}
