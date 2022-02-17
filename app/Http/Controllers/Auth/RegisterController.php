<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Traits\SendOtp;
use App\Models\SmsOtp;
use Carbon\Carbon;
use Auth as UserAuth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, SendOtp;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'password_change' => 1,
        ]);
    }

    public function showRegister()
    {
        return redirect('/login');
    }

    public function studentRegister(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        
        // $input = $request->all();

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->password_change = 1;
        $user->role = "Student";
        $user->save();
        $user->assignRole('Student');

        if($user) {
            UserAuth::attempt(['email' => $request->email, 'password' => $request->password]);

            return redirect('/home');

        }else {
            return redirect()->back();
        }
        // flash('Successful Student Register. Please Wait until approved by admin.')->success()->important();
        // return redirect()->route('login');
    }

    public function requestOtp(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email',
            'phone'     => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $phone = $request->phone;
        $is_register = $request->is_register;
        $otp = SmsOtp::where('phone',$phone)->first();
        $data = $request->all();
        if (!$otp) {

            $otp = new SmsOtp();
            $otp->phone = $phone;
            $otp->otp = mt_rand(100000, 999999);
            $otp->save();
            $this->sendOtp($otp->phone, config('lesson_type.code').$otp->otp);
            return view('auth.otp_confirm',compact('data'));
        }else{
            if ($otp->resend_otp_count < 3) {
                // $otp->otp = "123456";
                $otp->otp = mt_rand(100000, 999999);
                $otp->resend_otp_count += 1;
                $otp->update();
                $this->sendOtp($otp->phone,config('lesson_type.code').$otp->otp);
                return view('auth.otp_confirm',compact('data'));
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
                    return view('auth.otp_confirm',compact('data'));
                } else {
                    flash('Too Many Requests')->success()->important();
                    return redirect()->back();
                }
            }
        }

    }

    public function resendOtp(Request $request)
    {
        $phone = $request->phone;
        $is_register = $request->is_register;
        $otp = SmsOtp::where('phone',$phone)->first();
        // $data = $request->all();
        if (!$otp) {

            $otp = new SmsOtp();
            $otp->phone = $phone;
            $otp->otp = mt_rand(100000, 999999);
            $otp->save();
            $this->sendOtp($otp->phone, config('lesson_type.code').$otp->otp);
            // return view('auth.otp_confirm',compact('data'));
            return response()->json([
                "success" => true,
                'message'=> "Verification code sent!"
            ]);
        }else{
            if ($otp->resend_otp_count < 3) {
                // $otp->otp = "123456";
                $otp->otp = mt_rand(100000, 999999);
                $otp->resend_otp_count += 1;
                $otp->update();
                $this->sendOtp($otp->phone,config('lesson_type.code').$otp->otp);
                return response()->json([
                    "success" => true,
                    'message'=> "Verification code sent!"
                ]);
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
                    return response()->json([
                        "success" => true,
                        'message'=> "Verification code sent!"
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message'=> "Too Many Requests"
                    ]);
                }
            }
        }
    }

    public function registerConfirm()
    {
        return view('auth.register_confirm');
    }

    public function storeUser(Request $request)
    {
        $otp = SmsOtp::where('phone',$request['phone'])->where('otp', $request['verification_code'])->first();

        if($otp) {
            $input = $request->except('verification_code');
            $input['password'] = Hash::make($request['password']);
            $input['password_change'] = 1;
    
            $user = User::create($input);
    
            UserAuth::attempt(['phone' => $request['phone'], 'password' => $request['password']]);
    
            return redirect('/home');
        }else {
            flash('Your vertification code is not correct!')->success()->important();
            return redirect()->back();
        }
        
    }
}
