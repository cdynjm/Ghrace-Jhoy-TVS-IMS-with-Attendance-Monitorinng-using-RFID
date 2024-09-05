<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Hash;

class ForgotPasswordController extends Controller
{
    public function forgotPassword() {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request) {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm($token) {
        $email = request()->query('email');
    
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email
        ]);
    }

    public function reset(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'token' => 'required'
        ], [
            'password.confirmed' => 'The password confirmation does not match.'
        ]);
    
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );
    
        if ($status === Password::PASSWORD_RESET) {
            // Log in the user
            $user = \App\Models\User::where('email', $request->email)->first();
            Auth::login($user);  // Log in the user automatically
    
            return redirect('/')->with('status', 'Your password has been reset and you are now logged in.');
        }
    
        return back()->withErrors(['email' => [__($status)]]);
    }
    
}
