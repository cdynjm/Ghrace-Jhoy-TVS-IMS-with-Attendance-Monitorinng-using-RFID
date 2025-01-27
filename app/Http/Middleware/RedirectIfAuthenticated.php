<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
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

        return $next($request);
    }
}
