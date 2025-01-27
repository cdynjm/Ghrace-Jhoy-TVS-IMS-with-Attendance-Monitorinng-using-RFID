<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Session;

class VerifyEmailController extends Controller
{
    public function notVerified() {
        if(Auth::user()->email_verified_at == null)
            return view('auth.not-verified');
        else {
            if(auth()->user()->role == 1)
                return redirect(RouteServiceProvider::ADMIN);
            if(auth()->user()->role == 2)
                return redirect(RouteServiceProvider::REGISTRAR);
            if(auth()->user()->role == 3)
                return redirect(RouteServiceProvider::TRAINER);
            if(auth()->user()->role == 4)
                return redirect(RouteServiceProvider::STUDENT);
            if(auth()->user()->role == 5)
                return redirect(RouteServiceProvider::RFID);
        }
            
    }

    public function verify(EmailVerificationRequest $request) {

        $request->fulfill($request);
        $status = "Your email verification was successful. Please reload the page or log in to your account again to proceed.";
        session()->flash('emailStatus', $status);

        if(Auth::check()) {
            if(Auth::user()->role == 4) {
                return redirect('/student/dashboard');
            }
        }
        else {
            return redirect('/');
        }
    }
}
