<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseModule;
use Auth;
use App\User;
use App\Models\Grading;
use App\Models\QuestionPerPage;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\StudentExam;
use App\Models\Lesson;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::id());
        if($user->hasRole(['Student'])) {
            return redirect('/home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $course = Course::find($request->course_id);
        $module = CourseModule::find($request->module_id);
        $type = $request->type;
        
        $gradings = Grading::select('ref_no', 'awarding_body','grading_from','grading_to','grading_description','is_active')->groupBy('ref_no')->get();
        $questions_per_page = QuestionPerPage::pluck('description', 'id')->toArray();

        $attempts_allow = [
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            0 => 'Unlimited',
        ];

        return view('frontend.exams.create',compact('course','module','type','gradings','questions_per_page','attempts_allow'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except(['_token','is_limited']);

        $this->validate($request, [
            'exam_name' => 'required',
            'shuffle_question' => 'required',
        ]);

        $data['course_id'] = $request->course_id;
        $data['course_module_id'] = $request->module_id;
        $data['course_module_id'] = $request->module_id;
        $data['lesson_type'] = 4;
        $data['name'] = $request->exam_name;
        $data['description'] = $request->description;
        $data['open_quiz_date'] = $request->start_date;
        $data['close_quiz_date'] = $request->end_date;
        if(!isset($request->time_limit)) $data['time_limit'] = 0;
        if(!isset($request->time_limit)) $data['time_type'] = 0;
        $data['created_by'] = Auth::id();
        $order_no = Lesson::where('course_module_id',$request->module_id)->max('order_no')+1;
        $data['order_no'] = $order_no;
        $data['is_active'] = 1;
        $lesson = Lesson::create($data);


        if(!isset($request->time_limit)) $input['time_limit'] = 0;
        if(!isset($request->time_limit)) $input['time_type'] = 0;
        $input['created_by'] = Auth::id();
        $input['lesson_id'] = $lesson->id;

        $exam = Exam::create($input);

        

        flash('Exam created successful!')->success()->important();
        return redirect('/courses/detail/'.$exam->course->slug.'?module_id='.$exam->module_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam, $id)
    {
        $exam = Exam::find($id);
        $student_exam = StudentExam::where('exam_id', $exam->id)->where('exam_by', Auth::id())->get();

        // $current_exam = StudentExam::where('exam_id', $exam->id)->where('exam_by', Auth::id())->where('state', '=', 'Start')->orderBy('id','DESC')->first();
        
        // if($current_exam) {
        //     return redirect('/exams/start_exam/'.$id.'?course_id='.$exam->course_id.'&module_id='.$exam->module_id);
        // }
        
        return view('frontend.exams.show', compact('exam','student_exam'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam)
    {
        $gradings = Grading::select('ref_no', 'awarding_body','grading_from','grading_to','grading_description','is_active')->groupBy('ref_no')->get();
        $questions_per_page = QuestionPerPage::pluck('description', 'id')->toArray();
        $attempts_allow = [
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            0 => 'Unlimited',
        ];

        return view('frontend.exams.edit', compact('exam', 'gradings','questions_per_page', 'attempts_allow'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam)
    {
        $type = $request->type;

        $lesson = Lesson::where('id', $exam->lesson_id)->first();
        if(empty($lesson)) {
            $lesson = New Lesson();
        }

        $lesson->course_id          = $request->course_id;
        $lesson->course_module_id   = $request->module_id;
        $lesson->lesson_type        = 4;
        $lesson->name               = $request->exam_name;
        $lesson->description        = $request->description;
        if(isset($request->start_date)) {
            $lesson->open_quiz_date = $request->start_date;
        }
        if(isset($request->start_date)) {
            $lesson->close_quiz_date = $request->end_date;
        }
        if(!isset($request->time_limit)) $lesson->time_limit = 0;
        if(!isset($request->time_limit)) $lesson->time_type = 0;

        $lesson->created_by     = Auth::id();
        // $order_no               = Lesson::where('course_module_id',$request->module_id)->max('order_no')+1;
        // $lesson->order_no       = $order_no;
        $lesson->is_active      = 1;
        $lesson->save();

        // $lesson = Lesson::where('id', $exam->lesson_id)->update($data);

        $input = $request->all();
        if(!isset($request->time_limit)) $input['time_limit'] = 0;
        if(!isset($request->time_limit)) $input['time_type'] = 0;
        $input['lesson_id'] = $lesson->id;
        $exam->update($input);

        if($type == "ajax"){
            return response()->json([
                "code" => 200,
                "message" => "Successfully updated!"
            ]);
        }

        return redirect('/courses/detail/'.$exam->course->slug.'?module_id='.$exam->module_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        $slug = $exam->course->slug;
        if(!empty($exam->lesson_id)) {
            Lesson::find($exam->lesson_id)->delete();
        }
        $questions = Question::where('exam_id', $exam->id)->get();
        foreach($questions as $question) {
            QuestionAnswer::where('question_id', $question->id)->delete();
            $question->delete();
        }
        
        $exam->delete();
        return redirect('/courses/detail/'.$slug);
    }

    public function changeStatus($id)
    {
       $exam = Exam::find($id);
       $status =  $exam->is_active;
       $exam->is_active = !$exam->is_active;
       $exam->save();

       if(!empty($exam->lesson_id)) {
        $lesson = Lesson::find($exam->lesson_id);
        $lesson->is_active = !$lesson->is_active;
        $lesson->save();
       }

       $msg = "Exam is successfully ".($status == 1 ? "unsuspended." : "suspended.");
       return response()->json([
           "code" => 200,
           "status" =>  $exam->is_active,
           "message" => $msg
       ]);
    }
}
