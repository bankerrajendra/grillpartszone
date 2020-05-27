<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm(Request $request)
    {
        $redirect = $request->has('redirect') ? $request->input('redirect') : '';
        return view('auth.login', [
            'redirect' => $redirect
        ]);
    }

    /**
     * @param Request $request
     * @param $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if ( $user->isAdmin() ) {// do your magic here
            return redirect()->route('admin');
        } else {
            if($user->hasOneRole('user')) {
                if($request->has('redirect')) {
                    return Redirect::to(urldecode($request->input('redirect')));
                }
            }
        }

        return redirect('/');
    }
}
