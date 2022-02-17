<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\Models\LoginActivity;
use Carbon\Carbon;
use App\User;
use Session;
use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;

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

    public function login(Request $request)
    {

        $this->validate($request, [
            'password' => 'required',
        ]);

        $username = $request->username;

        $remember = $request->has('remember') ? true : false;

        if(filter_var($username, FILTER_VALIDATE_EMAIL)) {
            Auth::attempt(['email' => $username, 'password' => $request->password], $remember);
        }else {
            Auth::attempt(['phone' => $username, 'password' => $request->password], $remember);
            // Auth::attempt(['username' => $username, 'password' => $request->password], $remember);
        }

        if ( Auth::check() ) {
            $user_id = Auth::id();
            $user = User::find($user_id);
            
            if(!$user->hasRole(['Super Admin','Admin']) && $request->auto == null) {
                if(empty($user->web_id)) {

                    $agent = new Agent();
                    $ip = request()->ip();
                    
                    $location = null;
                    if ($position = Location::get($ip)) {
                        $location = $position->cityName.', '.$position->countryName;
                    }
                    
                    $user->web_id = ($request->web_id)? $request->web_id:null;
                    $user->platform_web = ($request->platform_web)? $request->platform_web:null;
                    $user->device_name_web = ($agent->isMobile())? $agent->device():null;
                    $user->browser = $agent->browser();
                    $user->location = $location;
                    $user->device_ip_web = $ip;
                    $user->save();

                }else {
                    if($request->web_id != $user->web_id) {
                        auth()->logout();
    
                        flash('Please contact admin for your device activate.')->error()->important();
                        return redirect()->route('login'); 
                    }
                }
            }

            if(Auth::user()->password_change == false && $request->auto == null) {
                // auth()->logout();

                // flash('Please after reset password you can login.')->warning()->important();
                return redirect('/force_to_change_password/'.$user_id);
            }
            if(Auth::user()->is_active == false) {
                auth()->logout();

                flash('Please contact admin for your account active.')->error()->important();
                return redirect()->route('login'); 
            }else {

                LoginActivity::create([
                    'user_id'   => Auth::id(),
                    'login'     => Carbon::now(),
                    'ipaddress' => \Request::ip(),
                ]);

                if (Session::has('courseID')) {
                    $slug = Session::get('courseID');
                    Session::forget('courseID');
                    return redirect('/courses/detail/'.$slug);
                }
                if($request->auto){
                    $user->save();
                    return redirect('/chatify');
                }
                return redirect('/');
            }
            
        }else {
            
            flash('Invalid username or password!')->error()->important();
            return redirect()->route('login');
        }
    
    }

    public function logout()
    {
        $user = User::find(Auth::id());
        $login_activity = LoginActivity::where('user_id', $user->id)->orderBy('id', 'DESC')->first();
        if(!empty($login_activity)) {
            $login_activity->ipaddress  = \Request::ip();
            $login_activity->logout     = Carbon::now();
            $login_activity->save();
        }

        auth()->logout();
       
        return redirect()->route('home');
    }
}
