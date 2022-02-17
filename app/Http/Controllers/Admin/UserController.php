<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Mail;
use Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\TeamMember;
use Arr;
use Image;
use App\Mail\InformRegistration;
use App\Models\LoginActivity;
use App\Models\AdditionalUser;
use App\Models\Region;
use App\Models\Township;
use App\Imports\UsersImport;
use App\Exports\UsersExport;
use Excel;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Support\Facades\Validator;
use App\Models\Course;
use App\Models\EnrolUser;
use Exception;
use File;
use App\Models\StudentAnswer;
use App\Models\StudentExam;

use App\Models\Setting;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:list|create|edit|delete', ['only' => ['index','store']]);
        $this->middleware('permission:create', ['only' => ['create','store']]);
        $this->middleware('permission:edit', ['only' => ['edit','update']]);
        $this->middleware('permission:delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $role = $request->role;
        $course = $request->course;

        $user = User::find(Auth::id());
        if($user->hasRole(['Super Admin'])) {
            $users = User::leftJoin('enrol_users as enrol','enrol.user_id','=','users.id')
            ->orderBy('users.id','DESC');
        }else {
            $users = User::leftJoin('enrol_users as enrol','enrol.user_id','=','users.id')
            ->where('users.id','<>',1)->orderBy('users.id','DESC');
        }

        if(isset($request->role) && $role != "0" ) {
            $users = $users->where('role', $role);
        }
        if(isset($request->course) && $course != "0" ) {
            $users = $users->where('enrol.course_id', $course);
        }
        $users = $users->select('users.*')->groupBy('users.id')->get();

        $roles = ['0'=>'All Roles']+Role::orderBy('id', 'DESC')->pluck('name','name')->toArray();
        $courses = ['0'=>'All Courses']+Course::orderBy('id', 'DESC')->where('deleted_at', null)->pluck('course_name','id')->toArray();
        
        return view('admin.users.index',compact('users','roles','courses','course','role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::find(Auth::id());
        if($user->hasRole(['Super Admin'])) {
            $roles = Role::orderBy('id', 'DESC')->pluck('name','name')->all();
        }else {
            $roles = Role::where('id', '<>', 1)->orderBy('id', 'DESC')->pluck('name','name')->all();
        }

        $qualifications = $this->qualification();

        $regions = Region::pluck('name','id')->toArray();
        $townships = Township::pluck('name','id')->toArray();
        
        return view('admin.users.create',compact('roles', 'qualifications', 'regions', 'townships'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'name'      => 'required',
            // 'username'  => 'required|unique:users,username|regex:/^\S*$/u',
            'email'     => 'required|email|unique:users,email',
            'role'      => 'required',
            'phone'     => 'required',
            'nrc'       => 'required',
            // 'nrc'       => 'required|unique:users,nrc',
        ]);

        $input = $request->except(['additional_label','additional_value']);
    
        $input['password_change'] = 0;
        
        $setting = Setting::find(1);

        if($setting) {
            $input['password']  = Hash::make($setting->default_password);
            $password           = $setting->default_password;
        }else {
            $input['password']  = Hash::make("PsmLms123$");
            $password           = "PsmLms123$";
        }
        
        if(isset($request->photo)) {
            $photo = $_FILES['photo'];
            if(!empty($photo['name'])){
                $file_name = 'profile_'.time().'.'.$request->file('photo')->guessExtension();
                $tmp_file = $photo['tmp_name'];
                $img = Image::make($tmp_file);
                $img->save(public_path('/uploads/'.$file_name));
                $input['photo'] = $file_name;
            }
        }
        if(isset($request->citizenship_card)) {
            $citizenship_card = $_FILES['citizenship_card'];
            if(!empty($citizenship_card['name'])){
                $file_name = 'citizenship_card_'.time().'.'.$request->file('citizenship_card')->guessExtension();
                $tmp_file = $citizenship_card['tmp_name'];
                $img = Image::make($tmp_file);
                $img->save(public_path('/uploads/user_files/'.$file_name));
                $input['citizenship_card'] = $file_name;
            }
        }
        if(isset($request->passport_photo)) {
            $passport_photo = $_FILES['passport_photo'];
            if(!empty($passport_photo['name'])){
                $file_name = 'passport_photo_'.time().'.'.$request->file('passport_photo')->guessExtension();
                $tmp_file = $passport_photo['tmp_name'];
                $img = Image::make($tmp_file);
                $img->save(public_path('/uploads/user_files/'.$file_name));
                $input['passport_photo'] = $file_name;
            }
        }
        if(isset($request->qualification_photo)) {
            $qualification_photo = $_FILES['qualification_photo'];
            if(!empty($qualification_photo['name'])){
                $file_name = 'qualification_photo_'.time().'.'.$request->file('qualification_photo')->guessExtension();
                $tmp_file = $qualification_photo['tmp_name'];
                $img = Image::make($tmp_file);
                $img->save(public_path('/uploads/user_files/'.$file_name));
                $input['qualification_photo'] = $file_name;
            }
        }
        if(isset($request->transcript_photo)) {
            $transcript_photo = $_FILES['transcript_photo'];
            if(!empty($transcript_photo['name'])){
                $file_name = 'transcript_photo_'.time().'.'.$request->file('transcript_photo')->guessExtension();
                $tmp_file = $transcript_photo['tmp_name'];
                $img = Image::make($tmp_file);
                $img->save(public_path('/uploads/user_files/'.$file_name));
                $input['transcript_photo'] = $file_name;
            }
        }
        if(isset($request->lang_certificate_photo)) {
            $lang_certificate_photo = $_FILES['lang_certificate_photo'];
            if(!empty($lang_certificate_photo['name'])){
                $file_name = 'lang_certificate_photo_'.time().'.'.$request->file('lang_certificate_photo')->guessExtension();
                $tmp_file = $lang_certificate_photo['tmp_name'];
                $img = Image::make($tmp_file);
                $img->save(public_path('/uploads/user_files/'.$file_name));
                $input['lang_certificate_photo'] = $file_name;
            }
        }

        $user = User::create($input);
        $user->assignRole($request->input('role'));

        if(isset($request['additional_label'])) {
            if(count($request['additional_label']) > 0) {
                for($i=0; $i < count($request['additional_label']); $i++) {
                    $additional['user_id']          = $user->id;
                    $additional['additional_label'] = $request['additional_label'][$i];
                    $additional['additional_value'] = $request['additional_value'][$i];

                    AdditionalUser::create($additional);
                }
            }
        }

        if(!empty($user)) {
            // $token = app('auth.password.broker')->createToken($user);
            $emails = [$user->email];
            Mail::to($emails)
            ->send(new InformRegistration($user, $password));
        }

        flash('User created successful!')->success()->important();
        return redirect()->route('users.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('admin.users.show',compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        
        if($user->hasRole(['Super Admin'])) {
            $roles = Role::orderBy('id', 'DESC')->pluck('name','name')->all();
        }else {
            $roles = Role::where('id', '<>', 1)->orderBy('id', 'DESC')->pluck('name','name')->all();
        }

        $userRole = $user->roles->pluck('name','name')->all();
        $qualifications = $this->qualification();
        $additional_users = AdditionalUser::where('user_id', $id)->get();
        $regions = Region::pluck('name','id')->toArray();
        $townships = Township::pluck('name','id')->toArray();

        return view('admin.users.edit',compact('user','roles','userRole','qualifications','additional_users','regions', 'townships'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email,'.$id,
            'role'      => 'required',
            'phone'     => 'required',
            'nrc'       => 'required',
            // 'nrc'       => 'required|unique:users,nrc',
        ]);

        $input = $request->all();
        // $input['is_active'] = $request->is_active ? true : false;
        
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }

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
        if(isset($request->citizenship_card)) {
            $old_image = public_path().'/uploads/user_files/'.$user->citizenship_card;
			if (file_exists($old_image)) {
				try {
					File::delete($old_image);
				} catch (\Exception $e) {
					flash('Message: '.$e->getMessage())->success()->important();
					return redirect()->back();
				}
			}
            $citizenship_card = $_FILES['citizenship_card'];
            if(!empty($citizenship_card['name'])){
                $file_name = 'citizenship_card_'.time().'.'.$request->file('citizenship_card')->guessExtension();
                $tmp_file = $citizenship_card['tmp_name'];
                $img = Image::make($tmp_file);
                $img->save(public_path('/uploads/user_files/'.$file_name));
                $input['citizenship_card'] = $file_name;
            }
        }
        if(isset($request->passport_photo)) {
            $old_image = public_path().'/uploads/user_files/'.$user->passport_photo;
			if (file_exists($old_image)) {
				try {
					File::delete($old_image);
				} catch (\Exception $e) {
					flash('Message: '.$e->getMessage())->success()->important();
					return redirect()->back();
				}
			}
            $passport_photo = $_FILES['passport_photo'];
            if(!empty($passport_photo['name'])){
                $file_name = 'passport_photo_'.time().'.'.$request->file('passport_photo')->guessExtension();
                $tmp_file = $passport_photo['tmp_name'];
                $img = Image::make($tmp_file);
                $img->save(public_path('/uploads/user_files/'.$file_name));
                $input['passport_photo'] = $file_name;
            }
        }
        if(isset($request->qualification_photo)) {
            $old_image = public_path().'/uploads/user_files/'.$user->qualification_photo;
			if (file_exists($old_image)) {
				try {
					File::delete($old_image);
				} catch (\Exception $e) {
					flash('Message: '.$e->getMessage())->success()->important();
					return redirect()->back();
				}
			}
            $qualification_photo = $_FILES['qualification_photo'];
            if(!empty($qualification_photo['name'])){
                $file_name = 'qualification_photo_'.time().'.'.$request->file('qualification_photo')->guessExtension();
                $tmp_file = $qualification_photo['tmp_name'];
                $img = Image::make($tmp_file);
                $img->save(public_path('/uploads/user_files/'.$file_name));
                $input['qualification_photo'] = $file_name;
            }
        }
        if(isset($request->transcript_photo)) {
            $old_image = public_path().'/uploads/user_files/'.$user->transcript_photo;
			if (file_exists($old_image)) {
				try {
					File::delete($old_image);
				} catch (\Exception $e) {
					flash('Message: '.$e->getMessage())->success()->important();
					return redirect()->back();
				}
			}
            $transcript_photo = $_FILES['transcript_photo'];
            if(!empty($transcript_photo['name'])){
                $file_name = 'transcript_photo_'.time().'.'.$request->file('transcript_photo')->guessExtension();
                $tmp_file = $transcript_photo['tmp_name'];
                $img = Image::make($tmp_file);
                $img->save(public_path('/uploads/user_files/'.$file_name));
                $input['transcript_photo'] = $file_name;
            }
        }
        if(isset($request->lang_certificate_photo)) {
            $old_image = public_path().'/uploads/user_files/'.$user->lang_certificate_photo;
			if (file_exists($old_image)) {
				try {
					File::delete($old_image);
				} catch (\Exception $e) {
					flash('Message: '.$e->getMessage())->success()->important();
					return redirect()->back();
				}
			}
            $lang_certificate_photo = $_FILES['lang_certificate_photo'];
            if(!empty($lang_certificate_photo['name'])){
                $file_name = 'lang_certificate_photo_'.time().'.'.$request->file('lang_certificate_photo')->guessExtension();
                $tmp_file = $lang_certificate_photo['tmp_name'];
                $img = Image::make($tmp_file);
                $img->save(public_path('/uploads/user_files/'.$file_name));
                $input['lang_certificate_photo'] = $file_name;
            }
        }

        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('role'));

        $arrID = [];
        if(isset($request['additional_label'])) {
            if(count($request['additional_label']) > 0) {
                for($i=0; $i < count($request['additional_label']); $i++) {
                    if(isset($request['additional_id'][$i])) {
                        $additional['user_id']          = $user->id;
                        $additional['additional_label'] = $request['additional_label'][$i];
                        $additional['additional_value'] = $request['additional_value'][$i];
        
                        $update_additional = AdditionalUser::where('id', $request['additional_id'][$i])->update($additional);
                        $arrID[] = $request['additional_id'][$i];
                    }else {
                        $additional['user_id']          = $user->id;
                        $additional['additional_label'] = $request['additional_label'][$i];
                        $additional['additional_value'] = $request['additional_value'][$i];
        
                        $save_additional = AdditionalUser::create($additional);
                        $arrID[] = $save_additional->id;
                    }
                }
            }
        }

        if (count($arrID) > 0)
        {
            DB::table("additional_users")->whereNotIn('id',$arrID)->where('user_id','=',$id)->delete();
        }

        flash('User updated successful!')->success()->important();
        return redirect()->route('users.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user) {
            EnrolUser::where('user_id', $id)->delete();
            StudentAnswer::where('exam_by', $id)->delete();
            StudentExam::where('exam_by', $id)->delete();
        }
        $user->delete();

        flash('User deleted successful!')->success()->important();
        return redirect()->route('users.index');
    }

    public function profile($id)
    {
        $user           = User::find($id);
        $first_access   = LoginActivity::where('user_id', $user->id)->first();
        $last_access    = LoginActivity::where('user_id', $user->id)->orderBy('id','DESC')->first();

        return view('admin.users.profile', compact('user','first_access', 'last_access'));
    }

    public function active($id)
    {
        User::where('id', $id)->update([
            'is_active' => true
        ]);
        return response()->json([
            'code' => 200,
            'message' => 'Successful Active',
        ]);
    }
    
    public function inactive($id)
    {
        User::where('id', $id)->update([
            'is_active' => false
        ]);
        return response()->json([
            'code' => 200,
            'message' => 'Successful Inactive',
        ]);
    }

    public function import(Request $request)
    {
        ini_set('max_execution_time', 5000);
        ini_set('upload_max_filesize', '70000M');
        ini_set('post_max_size', '70000M');
        ini_set('memory_limit', '70000M');

        if ($request->hasFile('import_file')) {

        // validate incoming request
        $this->validate($request, [
            'import_file' => 'required|file|mimes:xls,xlsx,csv|max:10240', //max 10Mb
        ]);

            if ($request->file('import_file')->isValid()) {
                Excel::import(new UsersImport, request()->file('import_file'));
            }
        }

        // flash('Users Import successfully!')->success()->important();
        return back();
    }

    public function export(Request $request)
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new UsersExport($request), 'users_'.time().'.xlsx');
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

    public function getTownship(Request $request)
    {
        $townships = Township::where('region_id', $request->region_id)->select(['id', 'name as text'])->get();

        return response()->json($townships);
    }

    public function switchRole($id)
    {
        $user = User::find($id);
        if($user->switch_role == null || $user->switch_role == "Super Admin") {
            $user->switch_role = 'Student';
        }
        elseif($user->switch_role == "Student") {
            $user->switch_role = "Super Admin";
        }
        $user->save();

        return redirect()->back();
    }

    public function resetWebDevice($id,Request $request)
    {
        $user = User::find($id);
        if($request->type == "web"){
            $user->web_id = null;
            $user->platform_web = null;
            $user->device_name_web = null;
            $user->device_ip_web = null;
            $user->browser = null;
        }else{
            $user->mobile_id = null;
            $user->mobile_device = null;
        }

        $user->save();

        return response()->json([
            'code' => 200,
        ]);
    }

    public function getAllColumn($id)
    {
        $user = User::find($id);

        return response($user);
    }

    public function userCourses(Request $request, $id)
    {
        $course = $request->course;

        $user = User::find($id);
        $enrolcourses = EnrolUser::where('user_id', $id)->where('is_active', 1)->latest('id')->get();

        if(isset($request->course) && $course != "0" ) {
            $enrolcourses = $enrolcourses->where('course_id', $course);
        }

        $ids = $enrolcourses->pluck('course_id');

        $courses = ['0'=>'All Courses']+Course::whereIn('id', $ids)
        ->orderBy('id', 'DESC')->where('deleted_at', null)->pluck('course_name','id')->toArray();

        return view('admin.users.courses', compact('user','enrolcourses','courses','course'));
    }
}
