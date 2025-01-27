<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\AdmissionApplication;
use App\Models\Announcement;
use Illuminate\Auth\Events\Registered;

class LoginController extends Controller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function login() {
        $status = AdmissionApplication::where('id', 1)->first();
        $enrollment = Announcement::where('id', 1)->first();
        return view('auth.login', ['status' => $status, 'enrollment' => $enrollment]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function authenticate(LoginRequest $request)
{
    try {
        $request->authenticate();
        $request->session()->regenerate();

        $user = User::where('id', Auth::user()->id)->first();
        $authToken = $user->createToken(\Str::random(50))->plainTextToken;
        $request->session()->put('token', $authToken);

        // Check if the user is verified
        if (!$user->hasVerifiedEmail()) {
            $lastEmailSentAt = $user->email_verification_sent_at;

            if (!$lastEmailSentAt || now()->diffInMinutes($lastEmailSentAt) >= 10) {
                // Send email verification
                $user->sendEmailVerificationNotification();

                // Update the timestamp for the last email sent
                $user->update(['email_verification_sent_at' => now()]);
            }
        }

        return response()->json([], 200);

    } catch (ValidationException $e) {
        return response()->json([
            'Message' => $e->getMessage(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['Error' => 0], Response::HTTP_OK);
    }
}
