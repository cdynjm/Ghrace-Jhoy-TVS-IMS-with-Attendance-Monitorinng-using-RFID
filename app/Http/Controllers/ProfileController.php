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
        // Validate input
        $validator = Validator::make($request->all(), [
            'profileEmail' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore(Auth::user()->id)
            ],
            'currentPassword' => 'required',
            'newPassword' => '',
            'confirmPassword' => 'same:newPassword',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'Message' => 'Validation Error',
                'errors' => $validator->errors()->toArray() // Return the errors as an array
            ], Response::HTTP_BAD_REQUEST);
        }
    
        // Verify current password
        if (!Hash::check($request->currentPassword, Auth::user()->password)) {
            return response()->json(['Message' => 'Current password is incorrect'], Response::HTTP_UNAUTHORIZED);
        }
    
        // Update name and email
        Auth::user()->update([
            'name' => $request->profileName,
            'email' => $request->profileEmail,
        ]);
    
        // Update password if new password is provided
        if (!empty($request->newPassword)) {
            Auth::user()->update([
                'password' => Hash::make($request->newPassword),
            ]);
        }
    
        return response()->json(['Message' => 'Profile Information updated Successfully'], Response::HTTP_OK);
    }
    
}
