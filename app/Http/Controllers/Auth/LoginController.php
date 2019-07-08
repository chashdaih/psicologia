<?php

namespace App\Http\Controllers\Auth;

use App\Partaker;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    // protected $redirectTo = '/home';
    protected function redirectTo()
    {
        redirect()->route('home');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        if(request()->num_cuenta) {
            $email = Partaker::where('num_cuenta', request()->num_cuenta)->first();
            if(count($email)) {
                request()->merge(['email' => $email->correo]);
            } else {
                return back()->with('num_cuenta', 'El número de cuenta no está registrado en nuestro sistema.');
            }
        }

        // dd(request());
    }
}
