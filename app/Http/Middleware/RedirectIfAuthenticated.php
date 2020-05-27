<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $user = Auth::user();
            if($user->isAdmin()) {
                return redirect()->route('admin');
            } else {
                if($request->has('redirect')) {
                    return Redirect::to(urldecode($request->input('redirect')));
                }
            }
            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
