<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class Admin {

    /**
     * @param $request
     * @param Closure $next
     * @return Application|RedirectResponse|Redirector|mixed
     */
    public function handle($request, Closure $next) {
        if(Auth::check() && Auth::user()->role == ADMIN_ROLE){

            return $next($request);
        }elseif (Auth::check() && Auth::user()->role == USER_ROLE) {

            return redirect(route('web.user.dashboard'));
        }
        Auth::logout();

        return redirect()->route('web.auth.sign_in')->with(['error' => __('You are not authorized')]);
    }
}
