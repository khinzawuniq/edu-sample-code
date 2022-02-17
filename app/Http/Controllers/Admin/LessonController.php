<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Lesson;
use App\Models\Course;
use App\Models\CourseModule;
use App\Models\Exam;
use App\Models\StudentAssignment;
use App\Models\LessonDuration;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data['created_by'] = Auth::id();
        $order_no = Lesson::where('course_module_id',$request->course_module_id)->max('order_no')+1;
        $data['order_no'] = $order_no;
        if(isset($request->file_path)) {
            $data['file_path'] = urldecode($request->file_path);
        }
        $lesson = Lesson::create($data);

        // if($lesson->lesson_type == 3) {
        //     $this->storeLessonDuration($lesson);
        // }

        return redirect('/courses/detail/'.$lesson->course->slug.'?module_id='.$lesson->course_module_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson)
    {
        $course = Course::find($lesson->course_id);

        $exams = Exam::where('course_id', $course->id)->pluck("exam_name","id")->toArray();
        
        return view('frontend.lessons.edit',compact('lesson','exams'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lesson $lesson)
    {
        $type = $request->type;
        $data = $request->all();
        if(isset($request->file_path)) {
            $data['file_path'] = urldecode($request->file_path);
        }
        $lesson->update($data);

        // if($lesson->lesson_type == 3) {
        //     $lesson_duration = LessonDuration::where('lesson_id', $lesson->id)->first();
        //     if(empty($lesson_duration)) {
        //         $lesson_duration = $this->storeLessonDuration($lesson);
        //     }
        // }

        if($type == "ajax"){
            return response()->json([
                "code" => 200,
                "message" => "Successfully updated!"
            ]);
        }

        return redirect('/courses/detail/'.$lesson->course->slug.'?module_id='.$lesson->course_module_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson)
    {

        $slug = $lesson->course->slug;
        $lesson->delete();
        return redirect('/courses/detail/'.$slug);
    }


    public function changeStatus($id)
    {
       $lesson = Lesson::find($id);
       $status =  $lesson->is_active;
       $lesson->is_active = !$lesson->is_active;
       $lesson->save();
       $msg = "Lesson is successfully ".($status == 1 ? "unsuspended." : "suspended.");
       return response()->json([
           "code" => 200,
           "status" =>  $lesson->is_active,
           "message" => $msg
       ]);
    }

    public function addLessonByType(Request $request)
    {

        $course = Course::find($request->course_id);
        $module = CourseModule::find($request->module_id);
        $type = $request->type == "zoom" ? "Zoom Meeting" : ucfirst($request->type);

        $exams = Exam::where('course_id', $course->id)->pluck("exam_name","id")->toArray();
        
        return view('frontend.lessons.create',compact('course','module','type','exams'));
    }


    public function gradeAssignment(Request $request)
    {
        $assignment_id = $request->assignment_id;
        $assignment = StudentAssignment::find($assignment_id);
        $assignment->mark = $request->mark;
        $assignment->remark = $request->remark;
        $assignment->save();
        return redirect('/admin/assignment-list?lesson_id='.$assignment->lesson_id);
    }

    public function assignmentList(Request $request)
    {
       $lesson_id = $request->lesson_id;
       $assignments = StudentAssignment::where('lesson_id',$lesson_id)->get();
       return view('frontend.assignments.index',compact('assignments'));
    }

    public function lessonOrderUpdate()
    {
        $lessons = Lesson::where('order_no','=','')->update([
            'order_no' => 1
        ]);

        dd('success');
    }

    public function storeLessonDuration($lesson)
    {
        $getID3 = new \getID3;
        $baseURL = url('/');
        
        $infoPath = pathinfo($lesson->file_path);
        $extension = $infoPath['extension'];
        
        if (!file_exists(storage_path('app/public/mytmp'))) {
            mkdir(storage_path('app/public/mytmp'));
        }
        
        $filename = 'mytmp/getID3'.time().'.'.$extension;

        $order = 'https://bucket-ox15x1.s3.ap-southeast-1.amazonaws.com';
        $lessonurl = urldecode($lesson->file_path);

        $filepath = str_replace($order, '', $lessonurl);

        $s3 = Storage::disk('public')->put(
            $filename, 
            Storage::disk('s3')->get($filepath));
        
        $filelocation = storage_path('app/public/').$filename;
        
        $file = $getID3->analyze($filelocation);
        
        $playtime_seconds = isset($file['playtime_seconds'])? $file['playtime_seconds']:0;
        $playtime_duration = round($playtime_seconds, 2);

        $duration_percent = ($playtime_duration*75)/100;

        $lesson_duration = LessonDuration::create([
            'course_id' => $lesson->course_id,
            'course_module_id' => $lesson->course_module_id,
            'lesson_id' => $lesson->id,
            'lesson_duration'=> $duration_percent,
        ]);
        
        unlink(storage_path('app/public/').$filename);

        return $lesson_duration;
    }

    public function downloadLesson($id)
    {
        $attachment = Lesson::find($id);
        $headers = [
            'Content-Disposition' => 'attachment; filename="'. $attachment->name .'.mp3"',
        ];

        $firstorder = 'https://bucket-ox15x1.s3.ap-southeast-1.amazonaws.com';
        $secondorder = '%20';

        $firstreplace = str_replace($firstorder, '', $attachment->file_path);
        $filepath = str_replace($secondorder, ' ', $firstreplace);
        
        return \Response::make(Storage::disk('s3')->get($filepath), 200, $headers);
    }
}
