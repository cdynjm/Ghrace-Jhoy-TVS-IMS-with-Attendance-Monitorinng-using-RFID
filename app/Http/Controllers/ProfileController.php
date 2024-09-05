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

use App\Models\User;


class ProfileController extends Controller
{
    public function updateProfile(Request $request) {

        if(Validator::make($request->all(), [
            'profileEmail' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore(Auth::user()->id)
            ]
        ])->fails()) { 
            return response()->json(['Message' => 'Email is already taken'], Response::HTTP_INTERNAL_SERVER_ERROR);
         }

         Auth::user()->update([
            'email' => $request->profileEmail
         ]);

         if(!empty($request->profilePassword)) {
            Auth::user()->update([
                'password' => Hash::make($request->profilePassword)
             ]);
         }

         return response()->json(['Message' => 'Profile Information updated Successfully'], Response::HTTP_OK);
    }
}
