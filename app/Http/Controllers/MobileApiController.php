<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseCategory;
use App\Models\Course;
use App\Models\PaymentDescription;
use App\Models\CourseModule;
use App\Models\Lesson;
use App\Models\BlogCategory;
use App\Models\EnrolUser;
use App\Models\BatchGroup;
use App\Models\StudentPayment;
use App\Models\StudentLessonDuration;
use App\Models\SmsOtp;
use App\Traits\SendOtp;
use Carbon\Carbon;
use Illuminate\Http\Response;
use App\User;
use Hash;
use Image;
use App\Models\BankAccount;
use App\Mail\MobileResetPassword;
use Mail;

class MobileApiController extends Controller
{

    use SendOtp;
    public function mobileLogin(Request $request)
    {

       $userbyPhone = User::where('phone',$request->name)->first(); 
       $userbyEmail = User::where('email',$request->name)->first(); 
       $mid = $request->mobile_id;
       $old_mid = "";
       $currentUser = null;
       $userPassword = "";
       if ($userbyPhone) {
          $userPassword = $userbyPhone->password;
          $old_mid = $userbyPhone->mobile_id;
          $currentUser = $userbyPhone;
       }
       if($userbyEmail){
          $userPassword = $userbyEmail->password;
          $old_mid = $userbyEmail->mobile_id;
          $currentUser = $userbyEmail;
       }
       $password = $request->password;
       if (($userbyEmail || $userbyPhone) && Hash::check($password,$userPassword)) {

            if ($old_mid) {
                if ($old_mid != $mid) {
                    return response()->json([
                        "success" => false,
                        "message" => "You don't have access to this account."
                    ]);
                }else{
                    return response()->json([
                        "success" => true,
                        "message" => "You have successfully logged in.",
                        "data" => $currentUser
                    ]);
                }
            }else{
                $currentUser->mobile_id = $mid;
                $currentUser->mobile_device = $request->agent_user;
                $currentUser->save();
                return response()->json([
                    "success" => true,
                    "message" => "You have successfully logged in.",
                    "data" => $currentUser
                ]);
            }

       }else{
        return response()->json([
            "success" => false,
            "message" => "Plase check user name and password."
        ]);
       }
    }


    public function requestOtp(Request $request)
    {
        $phone = $request->phone;
        $is_register = $request->is_register;
        $otp = SmsOtp::where('phone',$phone)->first();
        $user = User::where('phone',$phone)->first();
        if ($is_register) {
           if (!$user) {
            if (!$otp) {
                $otp = new SmsOtp();
                $otp->phone = $phone;
                $otp->otp = mt_rand(100000, 999999);
                $otp->save();
                $this->sendOtp($otp->phone, config('lesson_type.code').$otp->otp);
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
           }else{
            return response()->json([
                "success" => false,
                'message'=> "Your phone number is already existed in the system"
            ]);
           }
        }else{
            if (!$otp) {
                $otp = new SmsOtp();
                $otp->phone = $phone;
                $otp->otp = mt_rand(100000, 999999);
                $otp->save();
                $this->sendOtp($otp->phone, config('lesson_type.code').$otp->otp);
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

    }  
    

    public function checkOtp(Request $request)
    {
        $sms_otp = SmsOtp::where('phone',$phone)->where('otp',$otp)->first();
        if ($sms_otp) {
            return response()->json([
                "success" => true,
                'message'=> "Otp is correct!"
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message'=> "Your verification code is not correct!."
            ]);
        }
    }
    public function mobileRegister(Request $request)
    {
       $name = $request->name;
       $phone = $request->phone;
       $email = $request->email;
       $password = $request->password;
       $otp = $request->otp;
       $sms_otp = SmsOtp::where('phone',$phone)->where('otp',$otp)->first();
       if ($sms_otp) {
       $userbyPhone = User::where('phone',$phone)->first(); 
       $userbyEmail = User::where('email',$email)->first();

       if ($name && $phone && $email && $password) {
           if ($userbyPhone || $userbyEmail) {
               $message = $userbyPhone ? 'Your entered phone is already existed in the system!' :'Your entered email is already existed in the system!'; 
                return response()->json([
                    "success" => true,
                    "message" => $message
                ]);
           }
           $user = new User();
           $user->name = $name;
           $user->email = $email;
           $user->phone = $phone;
           $user->password = Hash::make($password);
           $user->save();

           return response()->json([
               "success" => true,
               "message" => "Account is successfully created",
               "data" => $user
           ]);
       }else{
        return response()->json([
            "success" => false,
            "message" => "Please check your information!"
        ]);
       }
    }else{
        return response()->json([
            "success" => false,
            "message" => "Something went wrong!"
        ]);
    }


    }
    public function getCategories()
    {
        $course_categories = CourseCategory::where('is_active',true)->get();
        return response()->json([
            "success" => true,
            "data" => $course_categories
        ]);
    }

    public function getHomePageData()
    {
        $course_categories = CourseCategory::where('is_active',true)->get();
        $courses = Course::where('is_active',true)->take(4)->orderBy('created_at','DESC')->get();
        $arr1 = [];
        $arr2 = [];
        foreach ($course_categories as $key => $category) {
           $arr1[$key]['id']  = $category->id;
           $arr1[$key]['type']  = 1;
           $arr1[$key]['name']  = $category->name;
           $arr1[$key]['image']  = $category->image;
           $arr1[$key]['description']  = "";
           $arr1[$key]['fees']  = 0;
           $arr1[$key]['fees_type']  = 0;
        }
        foreach ($courses as $key => $course) {
           $arr2[$key]['id']  = $course->id;
           $arr2[$key]['type']  = 2;
           $arr2[$key]['name']  = $course->course_name;
           $arr2[$key]['image']  = $course->image;
           $arr2[$key]['description']  = $course->description;
           $arr2[$key]['fees']  = $course->fees;
           $arr2[$key]['fees_type']  = $course->fees_type;
        }
        $array = array_merge($arr1,$arr2);
        return response()->json([
            "success" => true,
            "data" => $array
        ]);
    }

    public function getCourses(Request $request)
    {

        $id = $request->id;
        if($id <> null){
            $courseIds = EnrolUser::where('user_id',$id)->pluck('course_id')->toArray();
            $courses = Course::where('is_active',true)->whereIn('id',$courseIds)->orderBy('order_no')->get();
        }else{
           
        }
       
        return response()->json([
            "success" => true,
            "data" => $courses
        ]);
    }

    public function getCoursesByCategory(Request $request)
    {
        $courses = Course::where('course_category_id',$request->id)->where('is_active',true)->orderBy('order_no')->get();
        return response()->json([
            "success" => true,
            "data" => $courses
        ]);
    }
    public function getModules(Request $request)
    {
        $id = $request->id;
        $student_id = $request->student_id;
        $enrol_user = EnrolUser::where('course_id', $id)->where('user_id', $student_id)->first();
        $modules = CourseModule::where('course_id',$id)->where('is_active',true)->with(['lessons'])->orderBy('order_no')->get();
        if ($enrol_user) {
            $batch_group = BatchGroup::where('course_id', $id)->where('id', $enrol_user->batch_group_id)->first();
            if($batch_group) {
                $modules = $modules->filter(function($item)use($batch_group) {
                    foreach($batch_group->module as $m) {
                        if($item->id == $m->module_id) {
                            return $item;
                        }
                    }
                });
            }
        }

        $modules = collect($modules)->values();
        $ids = collect($modules)->pluck('id');
        $videos = Lesson::whereNotNull('file_path')->where('lesson_type',3)->whereIn('course_module_id',$ids)->where('is_active',true)->orderBy('order_no')->pluck('file_path','id')->toArray();
        $titles = Lesson::whereNotNull('file_path')->where('lesson_type',3)->whereIn('course_module_id',$ids)->where('is_active',true)->orderBy('order_no')->pluck('name','id')->toArray();
        return response()->json([
            "success" => true,
            "data" => $modules,
            "videos" => $videos,
            "titles" => $titles
        ]);
    }

    public function getLessonsByModuleId($id)
    {
        $lessons = Lesson::where('course_module_id',$id)->where('is_active',true)->get();
        return response()->json([
            "success" => true,
            "data" => $lessons
        ]);
    }


    public function changePassword(Request $request)
    {
       $id = $request->id;
       $password = $request->password;
       // email as phone
       $email = $request->phone;
       $confirm_password = $request->confirm_password;
       $old_password = $request->old_password;
       $is_reset = $request->is_reset;
       if ($is_reset) {
          $user = User::where('email',$email)->first();
          $user->password = Hash::make($confirm_password);
          $user->save();
          return response()->json([
            "success" => true,
            "message" => "Password has successfully changed."
        ]);
       }else{
           $user = User::find($id);
           if (Hash::check($old_password,$user->password)) {
             $user->password = Hash::make($confirm_password);
             $user->save();
             return response()->json([
                "success" => true,
                "message" => "Password has successfully changed."
            ]);
           }else{
            return response()->json([
                "success" => false,
                "message" => "Your old password doesn't match"
            ]);
           }
       }
    }


    public function enrollCourse(Request $request)
    {


        $payment = New StudentPayment();
        $payment->name = $request->name;
        $payment->email = $request->email;
        $payment->phone = $request->phone;
        $payment->course_id = $request->course_id;
        $payment->payment_type = $request->payment_type;
        $payment->payment_description = $request->payment_description;
        $payment->student_id = $request->student_id ?? 0;

        if(!empty($_FILES['photo']['name'])){
            $photo = $_FILES['photo'];
             $file_name = 'image_'.time().'.'.$request->file('photo')->guessExtension();
             $tmp_file = $photo['tmp_name'];
             $img = Image::make($tmp_file);
             $target_dir = "uploads/payment_slips";
             if (!file_exists($target_dir))
             {
               mkdir($target_dir,0777,true);
             }
             $img->resize(600, 600)->save(public_path($target_dir.'/'.$file_name));
             $payment->payment_screenshot = $file_name;
         }
         $payment->save();
        return response()->json([
            "success" => true,
            "data" => $payment,
            "message" => "We received your payment slip. We will contact you soon."
        ]);
    }

    public function updateUserData(Request $request)
    {

            $id = $request->id;
            $user = User::where('id',$request->id)->first();
            if($user){
            if($request->name){
                $user->name = $request->name;
            }
            if(!empty($_FILES['photo']['name'])){
               $photo = $_FILES['photo'];
                $file_name = 'profile_'.time().'.'.$request->file('photo')->guessExtension();
                $tmp_file = $photo['tmp_name'];
                $img = Image::make($tmp_file);
                $target_dir = "uploads";
                if (!file_exists($target_dir))
                {
                  mkdir($target_dir,0777,true);
                }
                $img->resize(600, 600)->save(public_path($target_dir.'/'.$file_name));
                $user->photo = $file_name;
                $user->save();
            }
            $user->save();
            return response()->json([
                "success" => true,
                "message" => "You have successfully updated your information.",
                "data" => $user
            ]);
        }else{
            return response()->json([
                "success" => false,
                "message" => "Invalid Information.Please Try Again"
            ]);
        }
    }


    public function getPayments()
    {
        $payments = BankAccount::get();
        $courses = Course::where('is_active', true)->get();
        $payfors = PaymentDescription::get();
        return response()->json([
            "success" => true,
            "data" => $payments,
            "courses" => $courses,
            "payfors" => $payfors
        ]);
    }

    public function syncLearningTime(Request $request)
    {
       $student_id = $request->student_id;
        if ($student_id) {
            $playtime = new StudentLessonDuration();
            $playtime->user_id = $student_id;
            $playtime->course_id = $request->course_id;
            $playtime->module_id = $request->module_id;
            $playtime->lesson_id = $request->lesson_id;
            $playtime->play = $request->play;
            $playtime->pause = $request->pause;
            $play = strtotime($request->play);
            $pause = strtotime($request->pause);
            $playtime->playtime_seconds = abs($play-$pause);
            $playtime->save();
            return response()->json([
                "success" => true,
            ]);
        }else{
            return response()->json([
                "success" => false,
            ]);
        }



    }

    public function getBlogs()
    {
       $blogs = BlogCategory::with('blogs.attachments')->get();
       return response()->json([
        "success" => true,
        "data" => $blogs
        ]);
    }
    public function getBlogsById(Request $request)
    {
       $id = $request->id;
       $blog = BlogCategory::find($id);
       if($blog){
        $blog = $blog->load('blogs.attachments');
        return response()->json([
         "success" => true,
         "data" => $blog
         ]);
       }else{
        return response()->json([
            "success" => false,
        ]);
       }

    }

    public function resetPassword(Request $request)
    {
        $email = $request->email;
        $userbyEmail = User::where('email',$email)->first();
        if($userbyEmail){
                $userbyEmail->password = Hash::make($request->confirm_password);
                $userbyEmail->password_change = 1;
                $userbyEmail->save();
                return response()->json([
                    "success" => true,
                    "password" => $request->confirm_password,
                    "data" => $userbyEmail,
                    "message" => "Successfully reset password."
                ]);
        }else{
            return response()->json([
                "success" => false,
                "message" => "Invalid Email.Please Try Again"
            ]);
        }
    }

    public function verifyCode(Request $request)
    {
        $code = $request->code;
        $email = $request->email;
        $success = false;
        if($email){
            $checkUser = User::where('email',$email)->where('verify_code',$code)->first();
            $success = $checkUser ? true : false;
        }
        return response()->json([
            'success' => $success
        ]);
    }
    public function requestVerifyCode(Request $request)
    {
        $email = $request->email;
        $success = false;
        if($email){
            $checkUser = User::where('email',$email)->first();
            if($checkUser){
                $nDigit = strlen($checkUser->id) < 6 ? (6 - strlen($checkUser->id)) : 0;
                $a = "";
                for ($i=0; $i < $nDigit ; $i++) { 
                   $a .= rand(0,9);
                }
                $checkUser->verify_code = $checkUser->id.$a;
                $checkUser->save();
                // Mail Send Code

                Mail::to($email)
                ->send(new MobileResetPassword($checkUser));
            }
            $success = $checkUser ? true : false;
        }
        return response()->json([
            'success' => $success
        ]);
    }
}
