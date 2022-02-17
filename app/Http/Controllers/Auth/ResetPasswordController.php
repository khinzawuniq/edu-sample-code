<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Hash;
use Auth;
use App\Models\LoginActivity;
use Carbon\Carbon;
use App\User;

use App\Traits\SendOtp;
use App\Models\SmsOtp;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords, SendOtp;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    // protected function rules()
    // {
    //     return [
    //         'token' => 'required',
    //         'email' => 'required|email',
    //         // 'password' => 'required|confirmed|string|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
    //         'password' => 'required|confirmed|min:6',
    //     ];
    // }

    public function reset(Request $request) {
        // dd($request->all());
        $this->validate($request, [
            'phone' => 'required',
            'password' => 'required|confirmed|min:6',
            'old_password' => 'required',
        ]);
        
        $phone = $request->phone;
        
        Auth::attempt(['phone' => $phone, 'password' => $request->old_password]);
        
        // if(Auth::attempt(['username' => $request->username, 'password' => $request->old_password]))
        if(Auth::check())
        {
            
            $user = User::find(Auth::id());
            if (Hash::check($request->old_password, $user->password)) {
             
                $user->password = Hash::make($request->password);
                $user->password_change = true;
                $user->save();
             
            } else {
                
                flash('Password does not match.')->success()->important();
                return redirect()->back();
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

                return redirect('/');
            }
        }else {
            flash('Password does not match.')->success()->important();
            return redirect()->back();
        }

        flash('Password has been successfully changed.')->success()->important();
        return redirect('/');
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
       
        return redirect()->route('login'); 
    }

    public function myPasswordReset(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            // 'phone' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::where('email', $request->email)->first();
        
        if(!empty($user)) {
            $user->password = Hash::make($request->password);
            $user->password_change = true;
            $user->save();

            Auth::attempt(['email' => $request->email, 'password' => $request->password]);

            if(Auth::check())
            {
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
                    flash('Password has been successfully changed.')->success()->important();
                    return redirect('/');
                } 
            }
        }else {
            flash('Your email is not registered in the system!')->success()->important();
            return back();
        }
    }

    public function showPasswordRequest()
    {
        
        return view('auth.passwords.phone');
    }

    public function PasswordRequestPhone(Request $request)
    {
        $this->validate($request, [
            'phone'     => 'required',
        ]);

        $phone = $request->phone;
        // $is_reset = $request->is_reset;
        $user = User::where('phone', $phone)->first();

        if($user) {
            $otp = SmsOtp::where('phone',$phone)->first();
            $data = $request->all();
            if (!$otp) {
    
                $otp = new SmsOtp();
                $otp->phone = $phone;
                $otp->otp = mt_rand(100000, 999999);
                $otp->save();
                $this->sendOtp($otp->phone, config('lesson_type.code').$otp->otp);
                return view('auth.reset_otp_confirm',compact('data'));
            }else{
                if ($otp->resend_otp_count < 3) {
                    dd('hello');
                    $otp->otp = mt_rand(100000, 999999);
                    $otp->resend_otp_count += 1;
                    $otp->update();
                    $this->sendOtp($otp->phone,config('lesson_type.code').$otp->otp);
                    return view('auth.reset_otp_confirm',compact('data'));
                } else {
                    $now = Carbon::now();
                    $banTime = Carbon::parse($otp->ban_time);
                    $diffMinutes = $banTime->diffInMinutes($now);
                    $otp->ban_time = $now;
                    $otp->update();
    
                    if ($diffMinutes >= 1) {
                        $otp->resend_otp_count = 0;
                        $otp->update();
                        // $otp->otp = "123456";
                        $otp->otp = mt_rand(100000, 999999);
                        $otp->resend_otp_count += 1;
                        $otp->ban_time = null;
                        $otp->update();
                        $this->sendOtp($otp->phone,config('lesson_type.code').$otp->otp);
                        return view('auth.reset_otp_confirm',compact('data'));
                    } else {
                        flash('Too Many Requests')->success()->important();
                        return redirect()->back();
                    }
                }
            }
        }else {
            flash('Your phone is not registered in the system!')->success()->important();
            return redirect()->back();
        }
    }

    public function PasswordConfirmOtp(Request $request)
    {
        $otp = SmsOtp::where('phone',$request['phone'])->where('otp', $request['verification_code'])->first();
        if($otp) {
            $data = $request->all();
            if(isset($request->is_reset)) {
                return view('auth.passwords.reset',compact('data'));
            }else {
                return view('auth.reset_password',compact('data'));
            }
            
        }else {
            flash('Your vertification code is not correct!')->success()->important();
            return redirect()->back();
        }
    }

    public function UserPasswordRequest($id)
    {
        $user = User::find($id);
        return view('auth.passwords.reset_password', compact('user'));
    }

    public function forceToChangePassword($id)
    {
        $user = User::find($id);
        
        return view('auth.forcetochange', compact('user'));
    }
}