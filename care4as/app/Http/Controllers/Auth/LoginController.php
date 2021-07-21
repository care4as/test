<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function loginview()
    {
      return view('auth.login');
    }
    public function login(Request $request)
    {
      $request->validate([
        'name' => 'required',
        'password' => 'required',
      ]);

      $credentials = array('name' => $request->name, 'password' => $request->password);

      // dd($credentials);

      if(Auth::attempt($credentials))
      {
        if(Auth::User()->role == 'Agent')
        {
          return Redirect()->route('dashboard');
        }
        elseif (Auth::User()->role == 'AgentTelefonica') {
          return Redirect()->route('pausetool');
        }
        else {
          return Redirect()->route('dashboard.admin');
        }
      }
      else {
          return view('auth.login')->withErrors('Zugangsdaten falsch');
      }
    }
    public function logout()
    {
      return redirect('login')->with(Auth::logout());
    }


}
