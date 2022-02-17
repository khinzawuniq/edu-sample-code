<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Image;
use Auth;
use Excel;
use App\Imports\CoursesImport;
use App\Exports\CoursesExport;
use App\Models\CourseModule;
use App\Models\Lesson;
use App\Models\Exam;
use App\Models\ChatGroup;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = CourseCategory::pluck('name','id')->toArray();
        return view('admin.course.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except(['_token','photo','is_limited']);
        
        $data['is_active'] = 1;
        if (!$request->is_limited) {
           $data['start_date'] = null;
           $data['end_date'] = null;
        }
        if(isset($request->enable_enrol_no)) {
            $data['enable_enrol_no'] = 1;
        }else {
            $data['enable_enrol_no'] = 0;
        }
        $data['created_by'] = Auth::id();
        
        $title = strtolower($request->course_name);
        $data['slug'] = str_replace(" ", "-", $title);
        
        // $path = Storage::disk('s3')->put('images', $request->image);
        // $path = Storage::disk('s3')->url($path);
        // $data['image'] = $path;
        if(!empty($request->image)) {
            $data['image'] = urldecode($request->image);
        }

        $course = Course::create($data);

        if($course) {
            $chatgroup = New ChatGroup();

            $chatgroup->name      = $course->course_code;
            $chatgroup->course_id = $course->id;
            $chatgroup->avatar = "avatar.png";
            $chatgroup->active_status = 1;
            $chatgroup->save();

            $chatgroup->ref_no = 'g'.$this->generate_numbers((int) $chatgroup->id, 1, 5);
            $chatgroup->update();

        }

        return redirect(route('course_categories.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $categories = CourseCategory::pluck('name','id')->toArray();
        return view('admin.course.edit',compact('course','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $data = $request->except('_token','is_limited');
        // $data['is_active'] = $request->is_active ? false : true;
        // if(isset($request->photo)) {
        //     $photo = $_FILES['photo'];
        //     if(!empty($photo['name'])){
        //         $file_name = 'image_'.time().'.'.$request->file('photo')->guessExtension();
        //         $tmp_file = $photo['tmp_name'];
        //         $img = Image::make($tmp_file);
        //         $img->resize(600, 600)->save(public_path('/uploads/course_images/'.$file_name));
        //         $data['image'] = $file_name;
        //     }
        // }
        
        $title = strtolower($request->course_name);
        $data['slug'] = str_replace(" ", "-", $title);

        if (!$request->is_limited) {
            $data['start_date'] = null;
            $data['end_date'] = null;
        }
        if(isset($request->enable_enrol_no)) {
            $data['enable_enrol_no'] = 1;
        }else {
            $data['enable_enrol_no'] = 0;
        }

        // $path = Storage::disk('s3')->put('images', $request->image);
        // $path = Storage::disk('s3')->url($path);
        // $data['image'] = $path;
        if(!empty($request->image)) {
            $data['image'] = urldecode($request->image);
        }

        $course->update($data);

        if($course) {
            $chatgroup = ChatGroup::where('course_id', $course->id)->first();

            if(empty($chatgroup)) {
                $chatgroup = New ChatGroup();
            }
            
            $chatgroup->name      = $course->course_code;
            $chatgroup->course_id = $course->id;
            $chatgroup->avatar = "avatar.png";
            $chatgroup->active_status = 1;
            $chatgroup->save();

            $chatgroup->ref_no = 'g'.$this->generate_numbers((int) $chatgroup->id, 1, 5);
            $chatgroup->update();
        }

        return redirect(route('course_categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect(route('course_categories.index'));
    }

    public function changeStatus($id)
    {
       $course = Course::find($id);
       $status =  $course->is_active;
       $course->is_active = !$course->is_active;
       $course->save();
       $msg = "Course is successfully ".($status == 1 ? "suspended." : "unsuspended.");
       return response()->json([
           "code" => 200,
           "status" =>  $course->is_active,
           "message" => $msg
       ]);
    }


    public function moveCourse(Request $request)
    {
       $course_ids = json_decode($request->course_ids);
       $category_id = $request->category_id;
       $categories = Course::whereIn('id',$course_ids)->update(['course_category_id'=> $category_id]);
       return redirect(route('course_categories.index'));
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
                Excel::import(new CoursesImport, request()->file('import_file'));
            }
        }

        flash('Courses Import successfully!')->success()->important();
        return back();
    }

    public function export(Request $request)
    {
        ob_end_clean(); ob_start();

        return Excel::download(new CoursesExport($request), 'courses_'.time().'.csv');
    }

    public function copy($id)
    {
        $course = Course::find($id);

        return response()->json($course);
    }

    public function copySave(Request $request)
    {
        $data = $request->except(['_token','photo','is_limited','copy_course','old_course_id']);
        $old_course_id = $request->old_course_id;
        
        $data['is_active'] = 1;
        if (!$request->is_limited) {
           $data['start_date'] = null;
           $data['end_date'] = null;
        }
        if(isset($request->enable_enrol_no)) {
            $data['enable_enrol_no'] = 1;
        }else {
            $data['enable_enrol_no'] = 0;
        }
        $data['created_by'] = Auth::id();
        $course = Course::create($data);

        if($course) {
            $modules = CourseModule::where('course_id', $old_course_id)->get();
            foreach($modules as $m) {
                $course_module = CourseModule::create([
                    "name"=> $m->name,
                    "course_id" => $course->id,
                    "created_by" => $m->created_by,
                    "description" => $m->description,
                    "is_active" => $m->is_active,
                ]);
                
                $lessons = Lesson::where('course_module_id', $m->id)->where('course_id', $old_course_id)->get();
                if(!empty($lessons)) {
                    foreach($lessons as $l) {
                        $lesson = Lesson::create([
                            'course_id'             => $course->id,
                            'course_module_id'      => $course_module->id,
                            'name'                  => $l->name,
                            'description'           => $l->description,
                            'order_no'              => $l->order_no,
                            'file_path'             => $l->file_path,
                            'assingment_allow_submission_from_date' => $l->assingment_allow_submission_from_date,
                            'assingment_due_date'       => $l->assingment_due_date,
                            'assingment_cut_off_date'   => $l->assingment_cut_off_date,
                            'assingment_remind_date'    => $l->assingment_remind_date,
                            'is_display_description'    => $l->is_display_description,
                            'lesson_type'               => $l->lesson_type,
                            'url'                       => $l->url,
                            'open_quiz_date'            => $l->open_quiz_date,
                            'close_quiz_date'           => $l->close_quiz_date,
                            'time_limit'                => $l->time_limit,
                            'time_type'                 => $l->time_type,
                            'is_active'                 => $l->is_active,
                            "created_by"                => $l->created_by,
                            "zoom_id"                   => $l->zoom_id,
                            "zoom_password"             => $l->zoom_password,
                        ]);
                    }
                }
                
    
                $exams = Exam::where('module_id', $m->id)->where('course_id', $old_course_id)->get();
                if(!empty($exams)) {
                    foreach($exams as $e) {
                        $exam = Exam::create([
                            'course_id' => $course->id,
                            'module_id' => $course_module->id,
                            'exam_name' => $e->exam_name,
                            'description' => $e->description,
                            'exam_duration' => $e->exam_duration,
                            'duration_type' => $e->duration_type,
                            'time_limit' => $e->time_limit,
                            'time_type' => $e->time_type,
                            'start_date' => $e->start_date,
                            'end_date' => $e->end_date,
                            'attempts_allow' => $e->attempts_allow,
                            'shuffle_question' => $e->shuffle_question,
                            'passing_mark' => $e->passing_mark,
                            'grading_id' => $e->grading_id,
                            'grade_mark_from' => $e->grade_mark_from,
                            'grade_mark_to' => $e->grade_mark_to,
                            'grade_description' => $e->grade_description,
                            'question_per_page' => $e->question_per_page,
                            'created_by' => $e->created_by,
                            'is_active' => $e->is_active,
                        ]);
                    }
                }
            }
        }

        return redirect(route('course_categories.index'));
    }

    public function generate_numbers($start, $count, $digits) {

		for ($n = $start; $n < $start+$count; $n++) {

			$result = str_pad($n, $digits, "0", STR_PAD_LEFT);

		}
		return $result;
	}
}
