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

use App\Models\LearnersClass;
use App\Models\LearnersCourse;
use App\Models\LearnersProfile;
use App\Models\LearnersWork;

class AdminService implements AdminInterface {
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
}

?>