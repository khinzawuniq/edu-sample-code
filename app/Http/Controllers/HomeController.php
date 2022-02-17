<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\CourseCategory;
use App\Models\Course;
use App\Models\CourseModule;
use App\Models\Lesson;
use App\User;
use App\Models\EnrolUser;
use App\Models\StudentAssignment;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use App\Models\LoginActivity;
use App\Models\QuestionGroupName;
use App\Models\StudentPayment;

use App\Models\StudentExam;
use App\Models\Exam;
use App\Models\Region;
use App\Models\Township;
use Image;
use Exception;
use File;
use PDF;
use App\Models\CertificateTemplate;
use App\Models\BatchGroup;
use App\Models\SlideShow;
use App\Models\StudentLessonDuration;
use App\Models\FAQ;
use App\Models\ChatGroup;
use App\Models\CampusAddress;
use App\Models\Setting;
use App\Mail\ContactMail;
use Mail;
use App\Models\KnowledgeBlog;
use App\Models\BlogAttachment;
use App\Models\Note;
use App\Models\BlogAd;
use App\Models\LessonDuration;

use Artisan;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->route = (in_array(\Request::route()->getName(), ['user', config('chatify.path')]))
            ? 'user'
            : \Request::route()->getName();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        // if(Auth::user()->password_change == false) {
        //     return redirect('/force_to_change_password/'.Auth::user()->id);
        // }

        $course_categories  = CourseCategory::where('is_active', true)->take(4)->get();
        $courses            = Course::where('is_active', true)->orderBy('id', 'DESC')->orderBy('order_no','ASC')->get();

        $mycourses = [];
        if(Auth::check()) {
            $mycourses = Course::join('enrol_users','enrol_users.course_id','=','courses.id')
            ->where('user_id', Auth::id())->where('courses.is_active', true)
            ->orderBy('order_no')->select('courses.*')->get();
        }

        $current_exam = StudentExam::where('exam_by', Auth::id())->where('state', '=', 'Start')->orderBy('id','DESC')->first();
        
        if($current_exam) {
            $exam = Exam::where('id', $current_exam->exam_id)->whereNull('deleted_at')->first();
            if($exam) {
                return redirect('/exams/start_exam/'.$current_exam->exam_id.'?course_id='.$current_exam->course_id.'&module_id='.$current_exam->module_id);
            }
        }
        
        $slideshows = SlideShow::All();
        
        return view('frontend.home', compact('course_categories', 'courses', 'mycourses', 'slideshows'));
    }

    public function aboutus()
    {
        return view('frontend.about');
    }

    public function contact()
    {
        $setting = Setting::first();

        return view('frontend.contact', compact('setting'));
    }

    public function courseCategories()
    {
        $course_categories = CourseCategory::get();

        return view('frontend.course_categories', compact('course_categories'));
    }

    public function courses()
    {
        $course_categories = CourseCategory::get();
        $courses = Course::where('is_active', true)->orderBy('id','DESC')->orderBy('order_no','DESC')->get();

        $setting = Setting::first();

        return view('frontend.courses', compact('courses','course_categories','setting'));
    }
    
    public function myCourses()
    {
        if(!Auth::check()) {
            return redirect('/login');
        }

        $userId = auth()->user()->id;
        $user = User::find($userId);

        $setting = Setting::first();

        $mycourses = Course::leftjoin('enrol_users','enrol_users.course_id','=','courses.id');
            // ->where('user_id', $userId)
            if($user->hasRole(['Student','Teacher'])) {
                $mycourses = $mycourses->where('enrol_users.user_id', $userId);
            }
            $mycourses = $mycourses->where('courses.is_active', true)->whereNull('enrol_users.deleted_at')
            ->orderBy('courses.id', 'DESC')->orderBy('courses.order_no','DESC')->groupBy('courses.id')
            ->select('courses.*')->get();

        return view('frontend.my_courses', compact('mycourses','setting'));
    }

    public function myCourseShow($slug)
    {
        if(!Auth::check()) {
            Session::put('courseID',$slug);
            return redirect('/login');
        }

        $course = Course::where('slug', $slug)->first();

        $enrol_course = false;
        $auth_user = '';
        $super_admin = false;

        if(Auth::check()) {
            $auth_user = User::find(Auth::id());
            if($auth_user->hasRole(['Super Admin','Admin','Course Creator'])) {
                $super_admin = true;
            }
            $enrol_user = EnrolUser::where('course_id', $course->id)->where('user_id', $auth_user->id)->first();

            if(!empty($enrol_user)) {
                $enrol_course = true;
            }
        }

        $setting = Setting::first();
        
        return view('frontend.courses.my_show', compact('course','enrol_course','auth_user','super_admin','setting'));
    }
    
    public function courseCategory($slug)
    {
        $category = CourseCategory::where('slug', $slug)->first();
        if($category) {
            $courses = Course::where('course_category_id', $category->id)->where('is_active', true)->orderBy('id','DESC')->orderBy('order_no','DESC')->get();
        }

        return view('frontend.courses.courses', compact('courses'));
    }

    public function courseShow($slug)
    {
        $course = Course::where('slug', $slug)->first();

        $enrol_course = false;
        $auth_user = '';
        $super_admin = false;

        if(Auth::check()) {
            $auth_user = User::find(Auth::id());
            if($auth_user->hasRole(['Super Admin','Admin','Course Creator'])) {
                $super_admin = true;
            }
            $enrol_user = EnrolUser::where('course_id', $course->id)->where('user_id', $auth_user->id)->first();

            if(!empty($enrol_user)) {
                $enrol_course = true;
            }
        }

        $setting = Setting::first();
        
        return view('frontend.courses.show', compact('course','enrol_course','auth_user','super_admin','setting'));
    }
    
    public function courseDetail($slug, $chartid = null)
    {
        if(!Auth::check()) {
            Session::put('courseID',$slug);
            return redirect('/login');
        }

        // $messengerColor = '#2180f3';
        // $dark_mode = 'light';

        $messengerColor = Auth::user()->messenger_color;
        $dark_mode = Auth::user()->dark_mode < 1 ? 'light' : 'dark';

        $auth_user = User::find(Auth::id());
        
        $course = Course::where('slug', $slug)->first();
        $modules = CourseModule::where('course_id',$course->id)->orderBy('order_no','ASC')->get();
        // $users = User::where('role', 'Student')->pluck('name','id')->toArray();
        $user_course_groups = Course::join('enrol_users as enrol','enrol.course_id','=','courses.id')
        ->select('courses.*')->groupBy('courses.id')->get();

        $enrol_users = [""=>1]+EnrolUser::join('users','users.id','=','enrol_users.user_id')
        ->where('course_id', $course->id)->pluck('enrol_users.user_id')->toArray();

        $chatgroup = ChatGroup::where('course_id', $course->id)->first();

        if(empty($chatgroup)) {
            $chatgroup = New ChatGroup();
            $chatgroup->name      = $course->course_code;
            $chatgroup->course_id = $course->id;
            $chatgroup->avatar = "avatar.png";
            $chatgroup->active_status = 1;
            $chatgroup->save();

            $chatgroup->ref_no = 'g'.$this->generate_numbers((int) $chatgroup->id, 1, 5);
            $chatgroup->update();
        }
        
        $users = User::where('role', '!=','Super Admin')->whereNotIn('id', $enrol_users)->get();
        
        $durations = $this->courseDurations();
        $question_groups = [''=>'Select Question Group']+QuestionGroupName::pluck('group_name','id')->toArray();
        
        $batch_group = '';

        if($auth_user->hasRole(['Student'])) {
            $enrol_user = EnrolUser::where('course_id', $course->id)->where('user_id', $auth_user->id)->first();

            if(empty($enrol_user)) {
                flash('You need to register to access the course!')->success()->important();
                return redirect()->route('courses.show-student', $course->id);
                
            }else {
                if($enrol_user->is_active == 0) {
                    flash('Please contact admin suspended your account for this class!')->success()->important();
                    return redirect()->route('courses.show-student', $course->id);
                }
            }
            if(empty($enrol_user->start_activity)) {
                $enrol_user->start_activity = Carbon::now();
                $enrol_user->last_activity  = Carbon::now();
                $enrol_user->save();
            }else {
                $enrol_user->last_activity = Carbon::now();
                $enrol_user->save();
            }
            
            $batch_group = BatchGroup::where('course_id', $course->id)->where('id', $enrol_user->batch_group_id)->first();

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

        $lessons = $course->lessons;
        $lessons = $lessons->filter(function($item) {
            if($item->lesson_type == 3 && !empty($item->file_path)) {
                return $item;
            }
        });

        // dd($lessons);

        // $getID3 = new \getID3;
        // $lesson_duration = 0;
        // $baseURL = url('/');
        // foreach($lessons as $key=>$lesson) {
        //     $filepath = substr($lesson->file_path, 1);
        //     $file = $getID3->analyze($filepath);
        //     // dd($file['error']);
        //     $playtime_seconds = isset($file['playtime_seconds'])?$file['playtime_seconds']:0;
        //     $lesson_duration += round($playtime_seconds, 2);
        // }
        // $duration_percent = ($lesson_duration*75)/100;
        
        $duration_percent = $course->lessonDuration->sum('lesson_duration');
        $student_lesson_duration = $course->StudentLessonDuration->sum('playtime_seconds');
        // dd($student_lesson_duration);
        $batch_groups = BatchGroup::where('course_id', $course->id)->pluck('group_name','id')->toArray();

        $notes = Note::where('created_by', $auth_user->id)->orderBy('id', 'desc')->get();

        $this->deleteNullDuration($course->id, $auth_user->id);
        
        return view('frontend.courses.detail', compact('course','modules','users', 'enrol_users', 'chatgroup', 'durations','question_groups','user_course_groups','batch_group','batch_groups','student_lesson_duration','duration_percent'))
        ->with('chartid', ($chartid == null) ? 0 : $this->route . '_' . $chartid)
        ->with('route', $this->route)
        ->with('messengerColor', $messengerColor)
        ->with('dark_mode', $dark_mode)
        ->with('notes', $notes);
    }

    public function myCourseDetail($slug, $chartid = null)
    {
        if(!Auth::check()) {
            Session::put('courseID',$slug);
            return redirect('/login');
        }

        $messengerColor = Auth::user()->messenger_color;
        $dark_mode = Auth::user()->dark_mode < 1 ? 'light' : 'dark';

        $user_id = auth()->user()->id;
        
        $course = Course::where('slug', $slug)->first();
        
        $modules = CourseModule::where('course_id',$course->id)->orderBy('order_no', 'ASC')->get();
        
        // $users = User::where('role', 'Student')->pluck('name','id')->toArray();
        $user_course_groups = Course::join('enrol_users as enrol','enrol.course_id','=','courses.id')
        ->select('courses.*')->groupBy('courses.id')->get();

        $enrol_users = [""=>1]+EnrolUser::join('users','users.id','=','enrol_users.user_id')
        ->where('course_id', $course->id)->pluck('enrol_users.user_id')->toArray();

        $chatgroup = ChatGroup::where('course_id', $course->id)->first();
        
        if(empty($chatgroup)) {
            $chatgroup = New ChatGroup();
            $chatgroup->name      = $course->course_code;
            $chatgroup->course_id = $course->id;
            $chatgroup->avatar = "avatar.png";
            $chatgroup->active_status = 1;
            $chatgroup->save();

            $chatgroup->ref_no = 'g'.$this->generate_numbers((int) $chatgroup->id, 1, 5);
            $chatgroup->update();
        }
        
        $users = User::where('role', '!=','Super Admin')->whereNotIn('id', $enrol_users)->get();
        
        $durations = $this->courseDurations();

        $auth_user = User::find($user_id);

        $question_groups = [''=>'Select Question Group']+QuestionGroupName::pluck('group_name','id')->toArray();
        
        $batch_group = '';

        if($auth_user->hasRole(['Student'])) {
            $enrol_user = EnrolUser::where('course_id', $course->id)->where('user_id', $auth_user->id)->first();
            if(empty($enrol_user)) {
                flash('Please need to be register course!')->success()->important();
                return redirect()->back();
            }else {
                if($enrol_user->is_active == 0) {
                    flash('Please contact admin suspended you account for this class!')->success()->important();
                    return redirect()->route('courses.show-student', $course->id);
                }
            }
            if(empty($enrol_user->start_activity)) {
                $enrol_user->start_activity = Carbon::now();
                $enrol_user->last_activity  = Carbon::now();
                $enrol_user->save();
            }else {
                $enrol_user->last_activity = Carbon::now();
                $enrol_user->save();
            }

            $batch_group = BatchGroup::where('course_id', $course->id)->where('id', $enrol_user->batch_group_id)->first();

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

        $lessons = $course->lessons;
        $lessons = $lessons->filter(function($item) {
            if($item->lesson_type == 3 && !empty($item->file_path)) {
                return $item;
            }
        });

        // dd($lessons);

        // $getID3 = new \getID3;
        // $lesson_duration = 0;
        // $baseURL = url('/');
        // foreach($lessons as $key=>$lesson) {
        //     // $filepath = substr($lesson->file_path, 1);
        //     $file = $getID3->analyze($lesson->file_path);
        //     $playtime_seconds = isset($file['playtime_seconds'])? $file['playtime_seconds']:0;
        //     $lesson_duration += round($playtime_seconds, 2);
        // }
        // $duration_percent = ($lesson_duration*75)/100;
        
        $duration_percent = $course->lessonDuration->sum('lesson_duration');
        $student_lesson_duration = $course->StudentLessonDuration->sum('playtime_seconds');
        // dd($student_lesson_duration);

        $batch_groups = BatchGroup::where('course_id', $course->id)->pluck('group_name','id')->toArray();

        $notes = Note::where('created_by', $user_id)->orderBy('id', 'desc')->get();

        $this->deleteNullDuration($course->id, $user_id);
        
        return view('frontend.courses.detail', compact('course','modules','users', 'enrol_users', 'chatgroup', 'durations','user_course_groups','batch_group','batch_groups', 'student_lesson_duration', 'duration_percent','question_groups'))
        ->with('chartid', ($chartid == null) ? 0 : $this->route . '_' . $chartid)
        ->with('route', $this->route)
        ->with('messengerColor', $messengerColor)
        ->with('dark_mode', $dark_mode)
        ->with('notes', $notes);
    }

    public function enrolUser(Request $request, $course_id)
    {
        if(!Auth::check()) {
            return redirect('/login');
        }

        $enrol_users = EnrolUser::leftjoin('student_lesson_durations as duration','duration.user_id','=','enrol_users.user_id')
        ->where('enrol_users.course_id', $course_id);

        if(isset($request->filter_batch_id)) {
            if($request->filter_batch_id != 0) {
                $enrol_users = $enrol_users->where('batch_group_id', $request->filter_batch_id);
            }
        }

        $enrol_users = $enrol_users->select('enrol_users.*', DB::raw('sum(duration.playtime_seconds) as total_second'))
        ->groupBy('enrol_users.user_id')
        ->get();

        $users = User::where('role', 'Student')->pluck('name','id')->toArray();
        $durations = $this->courseDurations();

        $course = Course::find($course_id);

        $batch_groups = BatchGroup::where('course_id', $course_id)->pluck('group_name','id')->toArray();

        return view('frontend.courses.enrol_users', compact('enrol_users', 'course_id','users','durations','course','batch_groups'));
    }
    
    public function durationsList(Request $request)
    {
        $data = '';

        $learning_durations = StudentLessonDuration::where('course_id', $request->course_id)
        ->where('user_id', $request->user_id)
        ->where('playtime_seconds', '!=', null);
        if(isset($request->start_time) && isset($request->end_time)) {
            $from = Carbon::createFromFormat('d/m/Y H:i', $request->start_time)->format('Y-m-d H:i');
            $to = Carbon::createFromFormat('d/m/Y H:i', $request->end_time)->format('Y-m-d H:i');
            // dd($from, $to);
            $learning_durations = $learning_durations->whereBetween('created_at', [$from, $to]);

            $data = $request->all();
        }
        // dd($data);
        $learning_durations = $learning_durations->orderBy('id','DESC')->groupBy('created_at')->get();

        $total_duration = $learning_durations->sum('playtime_seconds');
        
        $enrol_user = EnrolUser::where('course_id', $request->course_id)->where('user_id', $request->user_id)->first();
        $course = Course::where('id', $request->course_id)->first();

        $H = floor($total_duration / 3600);
        $i = ($total_duration / 60) % 60;
        $s = $total_duration % 60;
        $total_hour = sprintf("%02d:%02d:%02d", $H, $i, $s);

        return view('frontend.learning_durations.durations_list', compact('learning_durations','enrol_user','total_duration','data','course','total_hour'));
    }

    public function deleteNullDuration($course_id, $user_id)
    {
        $learning_durations = StudentLessonDuration::where('course_id', $course_id)
        ->where('user_id', $user_id)
        ->whereNull('playtime_seconds')
        ->delete();

        return 'success';
    }
    
    public function deleteDuplicateDuration()
    {
        $learning_durations = StudentLessonDuration::select('id','created_at', DB::raw('count(`created_at`) as occurences'))
        ->groupBy('created_at')
        ->having('occurences', '>', 1)
        ->get();
        
        foreach($learning_durations as $learn) {
            $get_last = StudentLessonDuration::where('created_at', $learn->created_at)->latest('id')->first();
            StudentLessonDuration::where('created_at', $learn->created_at)->where('id','!=', $get_last->id)->delete();
        }

        return 'success';
    }

    public function getLearningDurations(Request $request)
    {
        $data = '';

        $learning_durations = StudentLessonDuration::where('course_id', $request->course_id)
        ->where('user_id', $request->user_id);
        if(isset($request->start_time) && isset($request->end_time)) {
            $from = Carbon::createFromFormat('d/m/Y H:i', $request->start_time)->format('Y-m-d H:i');
            $to = Carbon::createFromFormat('d/m/Y H:i', $request->end_time)->format('Y-m-d H:i');
            
            $learning_durations = $learning_durations->whereBetween('created_at', [$from, $to]);

            $data = $request->all();
        }
        
        $learning_durations = $learning_durations->orderBy('id','DESC')->groupBy('created_at')->get();

        $total_duration = $learning_durations->sum('playtime_seconds');
        
        $enrol_user = EnrolUser::where('course_id', $request->course_id)->where('user_id', $request->user_id)->first();
        $course = Course::where('id', $request->course_id)->first();

        // $seconds = 8525;
        $H = floor($total_duration / 3600);
        $i = ($total_duration / 60) % 60;
        $s = $total_duration % 60;
        $total_hour = sprintf("%02d:%02d:%02d", $H, $i, $s);

        return response()->json([
            'total_duration'=> $total_duration,
            'total_hour' => $total_hour,
        ]);
    }

    public function getModulesByCategory()
    {
        
    }

    public function courseDurations()
    {
        $course_durations = [];
        
        for($i=0; 365 >= $i; $i++) {
            if($i == 0) {
                $course_durations[] = 'Unlimited';
            }else {
                $course_durations[] = $i.' days';
            }
        }
        
        return $course_durations;
    }

    public function profile($userId)
    {
        if(!Auth::check()) {
            return redirect('/login');
        }
        $user = User::find($userId);
        $first_access   = LoginActivity::where('user_id', $user->id)->first();
        $last_access    = LoginActivity::where('user_id', $user->id)->orderBy('id','DESC')->first();

        return view('frontend.profile',compact('user','first_access', 'last_access'));
    }
    
    public function profileEdit($userId)
    {
        if(!Auth::check()) {
            return redirect('/login');
        }
        $user = User::find($userId);
        $qualifications = $this->qualification();
        $regions = Region::pluck('name','id')->toArray();
        $townships = Township::pluck('name','id')->toArray();

        return view('frontend.edit_profile',compact('user','qualifications','regions', 'townships'));
    }

    public function profileUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email,'.$id,
            'phone'     => 'required|unique:users,phone,'.$id,
            'nrc'       => 'required',
        ]);

        $input = $request->all();

        $user = User::find($id);

        if(isset($request->photo)) {
            $old_image = public_path().'/uploads/'.$user->photo;
			if (file_exists($old_image)) {
				try {
					File::delete($old_image);
				} catch (\Exception $e) {
					flash('Message: '.$e->getMessage())->success()->important();
					return redirect()->back();
				}
			}
            $photo = $_FILES['photo'];
            if(!empty($photo['name'])){
                $file_name = 'profile_'.time().'.'.$request->file('photo')->guessExtension();
                $tmp_file = $photo['tmp_name'];
                $img = Image::make($tmp_file);
                $img->save(public_path('/uploads/'.$file_name));
                $input['photo'] = $file_name;
            }
        }

        $user->update($input);

        flash('Profile updated successful!')->success()->important();
        return redirect()->route('profile', $id);
    }

    public function profilePhotoUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'photo' => 'required|mimes:jpg,jpeg,png,gif,svg|max:1024'
        ]);

        $input = $request->all();
        $user = User::find($id);

        if(isset($request->photo)) {
            $old_image = public_path().'/uploads/'.$user->photo;
			if (file_exists($old_image)) {
				try {
					File::delete($old_image);
				} catch (\Exception $e) {
					flash('Message: '.$e->getMessage())->success()->important();
					return redirect()->back();
				}
			}
            $photo = $_FILES['photo'];
            if(!empty($photo['name'])){
                $file_name = 'profile_'.time().'.'.$request->file('photo')->guessExtension();
                $tmp_file = $photo['tmp_name'];
                $img = Image::make($tmp_file);
                $img->save(public_path('/uploads/'.$file_name));
                $input['photo'] = $file_name;
            }
        }

        $user->update($input);

        flash('Profile photo updated!')->success()->important();
        return redirect()->route('profile', $id);
    }

    public function qualification()
    {
        $data = [
            "PhD"       => "PhD",
            "Master"    => "Master",
            "Bachelor"  => "Bachelor",
            "Dip"       => "Dip",
            "High School" => "High School"
        ];

        return $data;
    }


    public function getEndDate(Request $request)
    {
        $date = $request->start_date;
        $time = $request->time_limit;
        $type = $request->time_type;
        $plus = "+".$time." ".$type;
        $date = date('Y-m-d H:i',strtotime($plus, strtotime($date)));
        return response()->json([
            "end_date" => $date
        ]);
    }

    public function FAQ()
    {
        $faqs = FAQ::All();

        return view('frontend.faq', compact('faqs'));
    }



    public function sendOtp(Request $request)
    {

        $phone = "+".$request->phone;
        if (Config::get('app.env') === 'production' || Config::get('app.env') === 'development') {

            $data = array("to" => $phone,"body"=>"Hello");
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://triplesms.com/api/v1/message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer MjgzNjc0M2NiZGIwOTQxYzY4NzVkOGQ0MGUzM2FiYjEzOWIwYTE3ZjcyYTEyZmY3',
                'Content-Type: application/json',
                'Cookie: __cfduid=d03bdaf918d9ca22e4c101962a498d3fc1612105204'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            echo $response;
        }
        else{
            return "SMS Cannot sent from local server";
        }


    }

    public function saveModuleOrder(Request $request)
    {
        $orders = $request->list;
        foreach ($orders as $key => $id) {
            CourseModule::find($id)->update(["order_no" => $key]);
        }
        return response()->json([
            "success" => true
        ]);
    }

    public function saveCategoryOrder(Request $request)
    {
        $orders = $request->list;
        foreach ($orders as $key => $id) {
            CourseCategory::find($id)->update(["order_no" => $key]);
        }
        return response()->json([
            "success" => true
        ]);
    }
    public function saveLessonOrder(Request $request)
    {
        $orders = $request->list;
        foreach ($orders as $key => $id) {
            Lesson::find($id)->update(["order_no" => $key]);
        }
        return response()->json([
            "success" => true
        ]);
    }
    public function saveCourseOrder(Request $request)
    {
        $orders = $request->list;
        foreach ($orders as $key => $id) {
            Course::find($id)->update(["order_no" => $key]);
        }
        return response()->json([
            "success" => true
        ]);
    }


    public function uploadAssignment(Request $request)
    {
        $data = ["student_id" => Auth::id(),"submission_date" => date('Y-m-d H:i:s'),"lesson_id" => $request->lesson_id];
        if(isset($request->assignment_file)) {
            $assignment_file = $_FILES['assignment_file'];
            if(!empty($assignment_file['name'])){
                $file_name = 'assignment_'.time().'.'.$request->file('assignment_file')->guessExtension();
                $tmp_file = $assignment_file['tmp_name'];
                $request->assignment_file->move(public_path('/uploads/assignments'),$file_name);
                $data["assignment_file"] = $file_name;
            }
        }
        StudentAssignment::insert($data);
        $lesson = Lesson::find($request->lesson_id);
        return redirect('courses/detail/'.$lesson->course->id.'?module_id='.$lesson->module->id);
        
    }

    public function library()
    {
        return view('frontend.library');
    }

    public function certificatePayment(Request $request, $certificate_id)
    {
        // dd($request->all(), $certificate_id);
        $data = $request->all();
        $students = EnrolUser::where('enrol_users.course_id', $request->course_id)->get();
        
        // dd($students);
        $paid = $students->where('pay_status', 1)->count();
        $unpaid = $students->where('pay_status', 0)->count();

        return view('frontend.payments.payment-list', compact('certificate_id', 'data','paid','unpaid'));
    }
    
    public function paidList(Request $request, $certificate_id)
    {
        // dd($request->all(), $certificate_id);
        $data = $request->all();
        $students = EnrolUser::where('enrol_users.course_id', $request->course_id)->where('pay_status', 1)->get();

        return view('frontend.payments.paid_lists', compact('certificate_id', 'data','students'));
    }
    public function unpaidList(Request $request, $certificate_id)
    {
        // dd($request->all(), $certificate_id);
        $data = $request->all();
        $students = EnrolUser::where('enrol_users.course_id', $request->course_id)->where('pay_status', 0)->get();

        return view('frontend.payments.unpaid_lists', compact('certificate_id', 'data','students'));
    }

    public function doPaid(Request $request)
    {
        $ids = $request->ids;
        $result = EnrolUser::whereIn('id', explode(",", $ids))->update([
            'pay_status' => 1,
        ]);

        return response(200);
    }
    
    public function doUnPaid(Request $request)
    {
        $ids = $request->ids;
        $result = EnrolUser::whereIn('id', explode(",", $ids))->update([
            'pay_status' => 0
        ]);

        return response(200);
    }

    public function downloadCertificate($course_id, $lesson_id)
    {
        $auth_user = User::find(Auth::id());
        
        $course = Course::find($course_id);
        $lesson = Lesson::find($lesson_id);

        $enrol_course = EnrolUser::where('course_id', $course_id)->where('user_id', $auth_user->id)->first();

        if($lesson->display == 1) {
            $template = CertificateTemplate::find(2);
        }else {
            $template = CertificateTemplate::find(1);
        }
        

        $monthyear = date('F Y');
        $day = date('jS');
        $getstr = substr($day, -2);

        $order   = array("st", "nd", "rd", "th");
        
        $replace = "<sup>".$getstr."</sup>";
        $newday = str_replace($order, $replace, $day);

        $date = 'ON '.$newday.' '.$monthyear;

        $data = ['background_img' => $template->background_image, 'enrol_course' => $enrol_course,'date'=> $date];
        // dd($data);
        if($lesson->display == 1) {
            $pdf = PDF::loadView('frontend/pdf/certificate_portrait', $data)->setPaper('A4', 'portrait');
        }else {
            $pdf = PDF::loadView('frontend/pdf/certificate_landscape', $data)->setPaper('A4', 'landscape');
        }
        
        // return $pdf->stream($course->course_name.'_certificate.pdf');
        return $pdf->download($course->course_name.'_'.$enrol_course->user->name.'.pdf');

        // return view('frontend.pdf.certificate_landscape', compact('data'));
    }
    
    // public function downloadLandscapeCertificate($course_id)
    // {
    //     $auth_user = User::find(Auth::id());
        
    //     $course = Course::find($course_id);

    //     $enrol_course = EnrolUser::where('course_id', $course_id)->where('user_id', $auth_user->id)->first();

    //     $template = CertificateTemplate::find(1);

    //     $monthyear = date('F Y');
    //     $day = date('jS');
    //     $getstr = substr($day, -2);

    //     $order   = array("st", "nd", "rd", "th");
        
    //     $replace = "<sup>".$getstr."</sup>";
    //     $newday = str_replace($order, $replace, $day);

    //     $date = 'ON '.$newday.' '.$monthyear;

    //     $data = ['background_img' => $template->background_image, 'enrol_course' => $enrol_course,'date'=> $date];
    //     // dd($data);
    //     $pdf = PDF::loadView('frontend/pdf/certificate_landscape', $data)->setPaper('A4', 'landscape');
    //     // return $pdf->stream($course->course_name.'_certificate.pdf');
    //     return $pdf->download($course->course_name.'_'.$enrol_course->user->name.'.pdf');

    //     // return view('frontend.pdf.certificate_landscape', compact('data'));
    // }
    
    // public function downloadPortraitCertificate($course_id)
    // {
    //     $auth_user = User::find(Auth::id());
        
    //     $course = Course::find($course_id);

    //     $enrol_course = EnrolUser::where('course_id', $course_id)->where('user_id', $auth_user->id)->first();

    //     $template = CertificateTemplate::find(2);

    //     $monthyear = date('F Y');
    //     $day = date('jS');
    //     $getstr = substr($day, -2);

    //     $order   = array("st", "nd", "rd", "th");
        
    //     $replace = "<sup>".$getstr."</sup>";
    //     $newday = str_replace($order, $replace, $day);

    //     $date = 'ON '.$newday.' '.$monthyear;

    //     $data = ['background_img' => $template->background_image, 'enrol_course' => $enrol_course,'date'=> $date];
        
    //     $pdf = PDF::loadView('frontend/pdf/certificate_portrait', $data)->setPaper('A4', 'portrait');
    //     // return $pdf->stream($course->course_name.'_certificate.pdf');
    //     return $pdf->download($course->course_code.'_'.$enrol_course->user->name.'.pdf');

    //     // return view('frontend.pdf.certificate_portrait', compact('data'));
    // }

    public function checkWebDevice(Request $request, $userId)
    {
        $user = User::find($userId);
        if($user->hasRole(['Super Admin', 'Admin', 'Course Creator'])) {
            $status = 'match';
        }else {
            $uuid = $request->uuid;
            if($uuid != $user->web_id) {
                auth()->logout();
                $status = 'nomatch';
            }else {
                $status = 'match';
            }
        }

        return response()->json([
            'status' => $status,
        ]);
        
    }

    public function backup()
    {
        // Artisan::call('backup:run',['--only-db'=>true]);
        try {
            // start the backup process
            Artisan::call('backup:run',['--only-db'=>true]);
            $output = Artisan::output();
            // log the results
            Log::info("Backpack\BackupManager -- new backup started from admin interface \r\n" . $output);
            // return the results as a response to the ajax call
            // Alert::success('New backup created');
            return redirect()->back();
        } catch (Exception $e) {
            // Flash::error($e->getMessage());
            flash($e->getMessage())->success()->important();
            return redirect()->back();
        }
        
    }

    public function startLesson(Request $request)
    {
        $playtime = new StudentLessonDuration();
        $playtime->user_id = auth()->user()->id;
        $playtime->course_id = $request->course_id;
        $playtime->module_id = $request->module_id;
        $playtime->lesson_id = $request->lesson_id;
        $playtime->play = date('H:i:s');
        $playtime->save();

        return response()->json([
            'code'      => 200,
            'playtime'  => $playtime,
        ]);

    }
    
    public function pauseLesson(Request $request)
    {

        $pause_date = date('Y-m-d H:i:s', strtotime($request->pause_date));
        
        if(!empty($request->play_id)) {
            $playtime = StudentLessonDuration::find($request->play_id);
            if(!isset($request->pause_date)) {
                $playtime->pause = Carbon::now()->format('H:i:s');
                $playtime->updated_at = Carbon::now()->format('Y-m-d H:i:s');
            }else {
                $playtime->pause = date('H:i:s', strtotime($request->pause_date));
                $playtime->updated_at = date('Y-m-d H:i:s', strtotime($request->pause_date));
            }
            
            $play = strtotime($playtime->play);
            $pause = strtotime($playtime->pause);
            $playtime->playtime_seconds = abs($play-$pause);
            $playtime->save();
        }else {
            $playtime = '';
        }

        return response()->json([
            'code'      => 200,
            'playtime'  => $playtime,
        ]);

    }

    public function saveVideoDuration(Request $request)
    {
        $currentlesson_duration = LessonDuration::where('lesson_id', $request->lesson_id)->first();

        if(empty($currentlesson_duration)) {
            $lesson_duration = ($request->lesson_duration*75)/100;

            $currentlesson_duration = LessonDuration::create([
                'course_id' => $request->course_id,
                'course_module_id' => $request->course_module_id,
                'lesson_id' => $request->lesson_id,
                'lesson_duration'=> $lesson_duration,
            ]);
        }

        return response()->json([
            'code' => 200,
            'currentlesson_duration' => $currentlesson_duration,
        ]);
    }

    public function contactMail(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'subject' => 'required',
            'description' => 'required',
        ]);

        if(!empty($request->mycheck)) {
            return redirect()->back();
        }

        $input = $request->except('_token');
        
        $emails = ['paingsoemanagement.psm@gmail.com'];
        // $emails = ['khinzawlwin.mm@gmail.com'];

        Mail::to($emails)
            ->send(new ContactMail($input));

        return redirect('/contact');
    }

    public function knowledgeBlogs()
    {
        $setting = Setting::first();

        $blogs = KnowledgeBlog::with('attachments')
        ->where('is_active', 1)
        ->orderBy('id','desc')->paginate(12);

        $blogAd = BlogAd::first();
        
        return view('frontend.knowledge_blogs',compact('blogs','setting','blogAd'));
    }

    public function blogDetail($slug)
    {
        $setting = Setting::first();

        $blog = KnowledgeBlog::where('slug', '=', $slug)->first();

        $related_blogs = KnowledgeBlog::where('blog_category_id', $blog->blog_category_id)
        ->where('id', '!=', $blog->id)
        ->get()->take(4);

        $blogAd = BlogAd::first();

        return view('frontend.blogs.show', compact('blog','setting','related_blogs','blogAd'));
    }

    public function generate_numbers($start, $count, $digits) {

		for ($n = $start; $n < $start+$count; $n++) {

			$result = str_pad($n, $digits, "0", STR_PAD_LEFT);

		}
		return $result;
	}

}
