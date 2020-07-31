<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class EmailVerified
{
    /**
     * Handle an incoming request.
     *
     * @param $request
     * @param Closure $next
     * @return RedirectResponse|mixed
     */
    public function handle($request, Closure $next) {
        if (Auth::check() && Auth::user()->email_verified == ACTIVE_STATUS) {

            return $next($request);
        }elseif (Auth::check() && Auth::user()->email_verified == PENDING_STATUS) {

            return redirect()->route('web.auth.sign_in')
                ->with(['error' => __('You email is not verified. Please verify your email first')]);
        }
        Auth::logout();

        return redirect()->route('web.auth.sign_in')->with(['error' => __('You are not authorized')]);
    }
}

