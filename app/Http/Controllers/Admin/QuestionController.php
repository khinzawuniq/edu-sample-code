<?php

namespace App\Http\Controllers\Admin;

use App\Models\Question;
use App\Models\QuestionAnswer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Exam;
use App\Models\StudentExam;
use DB;
use Carbon\Carbon;
use App\Models\StudentAnswer;
use App\Models\Grading;
use PDF;
use App\Models\QuestionGroupName;
use App\Models\AssignQuestion;

class QuestionController extends Controller
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
    public function create(Request $request)
    {
        $data['course_id']  = $request->course_id;
        $data['module_id']  = $request->module_id;
        $data['exam_id']    = $request->exam_id;
        $data['question_group_id'] = 0;
        $data['question_group_name'] = '';

        if(isset($request->question_group_id)) {
            $data['question_group_id'] = $request->question_group_id;
            $data['question_group_name'] = $request->question_group_name;
        }

        $data['question_type']    = $request->question_type;
        $group_names = [''=>'Select Question Group']+QuestionGroupName::pluck('group_name','id')->toArray();
        return view('frontend.questions.create', compact('data','group_names'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            // 'course_id' => 'required',
            // 'module_id' => 'required',
            // 'exam_id' => 'required',
            'question_type' => 'required',
            'question_group_id' => 'required',
            'question' => 'required',
            'mark' => 'required',
        ]);

        if($request->question_type == 'multiple_choice') {
            $this->validate($request, [
                'answer_no_style' => 'required',
                'choice' => 'required',
                'correct' => 'required',
            ]); 
        }
        
        $input = $request->except(['correct','choice']);
        $input['created_by'] = Auth::id();
        $question = Question::create($input);

        if($question) {
            if($question->question_type == 'multiple_choice') {
                $numbering = $this->numberStyle($request->answer_no_style);

                for($i=0; count($request['choice']) > $i; $i++) {
                    $choice['question_id'] = $question->id;
                    $choice['answer'] = $request['choice'][$i];
                    $choice['answer_no'] = $numbering[$i+1];
                    QuestionAnswer::create($choice);
                }
            }
        }

        if(isset($request->question_group_name)) {
            return redirect('/question_group_names/'.$request->question_group_id);
        }else {
            return redirect('/courses/detail/'.$question->course->slug.'?module_id='.$question->module_id);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Question $question)
    {
        $question_answers = QuestionAnswer::where('question_id', $question->id)->get();
        $group_names = [''=>'Select Question Group']+QuestionGroupName::pluck('group_name','id')->toArray();
        $question_group_id = 0;
        if(isset($request->question_group_id)) {
            $question_group_id = $request->question_group_id;
        }
        // dd($question_answers);
        return view('frontend.questions.edit', compact('question','question_answers','group_names','question_group_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $this->validate($request, [
            'course_id' => 'required',
            'module_id' => 'required',
            'exam_id' => 'required',
            'question_type' => 'required',
            'question_group_id' => 'required',
            'question' => 'required',
            'mark' => 'required',
        ]);

        if($request->question_type == 'multiple_choice') {
            $this->validate($request, [
                'answer_no_style' => 'required',
                'choice' => 'required',
                'correct' => 'required',
            ]);
        }
        
        $input = $request->except(['correct','choice']);
        $question->update($input);

        $arrID = [];
        if($question) {
            if($question->question_type == 'multiple_choice') {
                $numbering = $this->numberStyle($request->answer_no_style);

                for($i=0; count($request['choice']) > $i; $i++) {
                    if(isset($request['answer_id'][$i])) {
                        $choice['question_id'] = $question->id;
                        $choice['answer'] = $request['choice'][$i];
                        $choice['answer_no'] = $numbering[$i+1];
                        $answer = QuestionAnswer::where('id', $request['answer_id'][$i])->update($choice);
                        $arrID[] = $request['answer_id'][$i];
                    }else {
                        $choice['question_id'] = $question->id;
                        $choice['answer'] = $request['choice'][$i];
                        $choice['answer_no'] = $numbering[$i+1];
                        $answer = QuestionAnswer::create($choice);
                        $arrID[] = $answer->id;
                    }
                }

                if (count($arrID) > 0)
                {
                    DB::table("question_answers")->whereNotIn('id',$arrID)->where('question_id','=',$question->id)->delete();
                }
            }
        }

        return redirect('/exams/question_list/'.$question->exam_id.'?course_id='.$question->course_id.'&module_id='.$question->module_id);
        // return redirect('/courses/detail/'.$question->course_id.'?module_id='.$question->module_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $slug = $question->course->slug;
        QuestionAnswer::where('question_id', $question->id)->delete();
        AssignQuestion::where('question_id', $question->id)->delete();
        $question->delete();
        return redirect('/courses/detail/'.$slug);
    }

    public function questionList(Request $request, $exam_id)
    {
        // $questions = Question::where('course_id', $request->course_id)->where('module_id', $request->module_id)->where('exam_id', $exam_id)
        // ->get();
        $questions = Question::join('assign_questions as assign','assign.question_id','=','questions.id')
        ->join('exams','exams.id','=','assign.exam_id')
        ->where('exams.id', $exam_id)
        ->where('assign.course_id', $request->course_id)
        ->select('questions.*')
        ->get();
        
        $exam = Exam::find($exam_id);
        $group = AssignQuestion::where('course_id', $request->course_id)->where('module_id', $request->module_id)
        ->where('exam_id', $exam_id)->orderBy('created_at','DESC')->first();
        $total_mark = 0;
        if(count($questions) > 0) {
            foreach($questions as $q) {
                $total_mark = number_format($total_mark) + number_format($q->mark);
            }
        }
        return view('frontend.questions.question_list',compact('questions','exam','group','total_mark'));
    }
    
    public function fromQuestionList(Request $request, $exam_id)
    {
        // $question_groups = [''=>'Select Question Group Name']+Question::groupBy('question_group_id')->pluck('question_group_id','question_group_name')->toArray();
        $question_groups = [''=>'Select Question Group']+QuestionGroupName::pluck('group_name','id')->toArray();
        $change_question_groups = [''=>'Select Change Group']+QuestionGroupName::pluck('group_name','id')->toArray();
        $exam = Exam::find($exam_id);
        return view('frontend.questions.from_question_list',compact('exam','question_groups', 'change_question_groups'));
    }

    public function getDataQuestionList(Request $request){

    }

    public function getQuestions(Request $request, $exam_id)
    {
        $ids = $request->ids;
        foreach (explode(",", $ids) as $key => $id) {
            $q = Question::find($id);

            $question = Question::create([
                'course_id'     => $q->course_id,
                'module_id'     => $q->module_id,
                'exam_id'       => $exam_id,
                'question_type' => $q->question_type,
                'question'      => $q->question,
                'correct_answer'=> $q->correct_answer,
                'answer_no_style'=> $q->answer_no_style,
                'mark'          => $q->mark,
                'created_by'    => Auth::id(),
                'group_status'  => $q->question_group_id,
            ]);

            if($question) {
                if($question->question_type == 'multiple_choice') {
                    $q_answers = QuestionAnswer::where('question_id', $q->id)->get();
                    foreach($q_answers as $qans) {
                        QuestionAnswer::create([
                            'question_id'   => $question->id,
                            'answer'        => $qans->answer,
                            'answer_no'     => $qans->answer_no,
                        ]);
                    }
                }
            }
            
		}

        return response()->json([
            'code' => 200,
        ]);
    }

    public function changeQuestionGroup(Request $request)
    {
        $ids            = $request->ids;
        $question_group = $request->question_group;
        // $change_group   = $request->change_group;
        $change_group   = QuestionGroupName::find($request->change_group);


        foreach (explode(",", $ids) as $key => $id) {
            Question::where('id', $id)->update([
                'question_group_id' => $change_group->id,
                'question_group_name' => $change_group->group_name,
            ]);
            
		}

        return response()->json([
            'code' => 200,
        ]);
    }

    public function getQuestionGroupName(Request $request) 
    {
        $question_group_id = $request->question_group_id;
        $questions = Question::where('question_group_id', $question_group_id)->select('questions.*','questions.id as q_id')->get();
        return response()->json($questions);
    }
    
    public function startExam(Request $request, $exam_id)
    {
        $exam = Exam::find($exam_id);
        if(empty($request->all())) {
            $slug = $exam->course->slug;
            return redirect('/my_courses/detail/'.$slug);
        }
        $myexam_attempts = StudentExam::where('course_id', $request->course_id)->where('module_id', $request->module_id)->where('exam_id', $exam_id)
        ->where('exam_by', Auth::id())->get();

        if($exam->attempts_allow != 0) {
            if($exam->attempts_allow <= count($myexam_attempts)) {
                flash('Exam limit attempts allow is '.$exam->attempts_allow.' time!')->warning()->important();
                return redirect('/courses/detail/'.$exam->course->slug.'?module_id='.$request->module_id);
            }
        }
        
        $questions = Question::join('assign_questions as assign','assign.question_id','=','questions.id')
        ->join('exams','exams.id','=','assign.exam_id')
        ->where('assign.course_id', $request->course_id)->where('assign.module_id', $request->module_id)
        ->where('exams.id', $exam_id);
        
        if($exam->shuffle_question == 1) {
            $questions = $questions->select('questions.*')->inRandomOrder()->get();
        }else {
            $questions = $questions->select('questions.*')->get();
        }

        // $num_style = ($questions[0]->answer_no_style)? $questions[0]->answer_no_style: 1;
        // $num = $questions[0]->numberStyle($num_style);
        // dd($num);

        if($exam->question_per_page == 1 || empty($exam->question_per_page)) {
            $morepages = 0;
        }else {
            $morepages = 1;
        }

        $reload_exam = StudentExam::where('exam_id', $exam->id)->where('exam_by', Auth::id())->where('state', '=', 'Back')->orderBy('id','DESC')->first();

        if($reload_exam) {
            $reload_exam->state = "Finished";
            $reload_exam->save();

            return redirect("/exam_result?course_id=".$exam->course_id."&module_id=".$exam->module_id."&exam_id=".$exam->id."&student_exam=".$reload_exam->id);
        }

        $current_exam = StudentExam::where('exam_id', $exam->id)->where('exam_by', Auth::id())->where('state', '=', 'Start')->orderBy('id','DESC')->first();

        $question_arr = [];
        $left['hour'] = 0;
        $left['minute'] = 0;
        $left['second'] = 0;
        $current['hour']    = 0;
        $current['minute']  = 0;
        $current['second']  = 0;
        $before_start = false;

        if($current_exam) {
            $before_start = true;
            $student_exam = $current_exam;

            $question_arr = $student_exam->beforeAnswer($current_exam->id, $exam->id)->pluck('question_id')->toArray();
            
            $date1 = Carbon::parse($student_exam->start_exam);
            $date2 = Carbon::now();
            // $date2 = Carbon::parse($student_exam->stop_exam);
            $interval = $date1->diff($date2);
            $left['hour'] = $interval->format('%h');
            $left['minute'] = $interval->format('%i');
            $left['second'] = $interval->format('%s');

            if($exam->duration_type == "hours") {
                $current['hour']    = ($exam->exam_duration - 1) - $left['hour'];
                $current['minute']  = 60 - $left['minute'];
                $current['second']  = 60 - $left['second'];

                if($current['hour'] < 0) {
                    $total_mark = StudentAnswer::where('course_id', $request->course_id)->where('module_id', $request->module_id)
                    ->where('exam_id', $exam_id)->where('exam_by', Auth::id())->sum('mark');
                    
                    if(empty($student_exam->stop_exam)) {
                        $student_exam->stop_exam = auth()->user()->last_online_at;
                    }

                    $datetime1 = Carbon::parse($student_exam->start_exam);
                    $datetime2 = Carbon::parse($student_exam->stop_exam);
                    $interval = $datetime1->diff($datetime2);
                    $student_exam->time_taken = $interval->format('%h:%i:%s');
                    $student_exam->grade = $total_mark.' out of 100.00';
                    $student_exam->total_mark = $total_mark;
                    $student_exam->state = "Finished";
                    $student_exam->save();

                    $data['start_exam'] = date('l, d F Y, H:i A' ,strtotime($student_exam->start_exam));
                    $data['stop_exam'] = date('l, d F Y, H:i A' ,strtotime($student_exam->stop_exam));
                    $data['time_taken'] = $this->timeTaken($datetime1, $datetime2);

                    return view('frontend.questions.exam_result', compact('exam','student_exam','data'));
                    
                }
                // dd($current['hour'], $current['minute'], $current['second']);
            }
            else {
                $current['hour']      = 0;
                $current['minute']    = ($exam->exam_duration-1) - $left['minute'];
                $current['second']    = 60 - $left['second'];
                
                if($current['minute'] < 0) {
                    $total_mark = StudentAnswer::where('course_id', $request->course_id)->where('module_id', $request->module_id)
                    ->where('exam_id', $exam_id)->where('exam_by', Auth::id())->sum('mark');
                    
                    if(empty($student_exam->stop_exam)) {
                        $student_exam->stop_exam = auth()->user()->last_online_at;
                    }

                    $datetime1 = Carbon::parse($student_exam->start_exam);
                    $datetime2 = Carbon::parse($student_exam->stop_exam);
                    $interval = $datetime1->diff($datetime2);
                    $student_exam->time_taken = $interval->format('%h:%i:%s');
                    $student_exam->grade = $total_mark.' out of 100.00';
                    $student_exam->total_mark = $total_mark;
                    $student_exam->state = "Finished";
                    $student_exam->save();

                    $data['start_exam'] = date('l, d F Y, H:i A' ,strtotime($student_exam->start_exam));
                    $data['stop_exam'] = date('l, d F Y, H:i A' ,strtotime($student_exam->stop_exam));
                    $data['time_taken'] = $this->timeTaken($datetime1, $datetime2);

                    return view('frontend.questions.exam_result', compact('exam','student_exam','data'));
                }
                // dd($current['hour'], $current['minute'], $current['second']);
            }

            // dd($left['hour'], $left['minute'], $left['second']);
        }else {
            $student_exam = StudentExam::create([
                "course_id" => $exam->course_id,
                "module_id" => $exam->module_id,
                "exam_id" => $exam->id,
                "exam_by" => Auth::id(),
                "start_exam" => Carbon::now(),
                "state" => 'Start',
            ]);
        }
        
        
        return view('frontend.questions.student_exam',compact('questions','exam','student_exam','morepages','question_arr','left','before_start','current'));
    }

    public function unNormalStopExam(Request $request, $student_exam_id)
    {
        $total_mark = StudentAnswer::where('course_id', $request->course_id)->where('module_id', $request->module_id)
        ->where('exam_id', $request->exam_id)->where('exam_by', Auth::id())->sum('mark');

        $student_exam = StudentExam::find($student_exam_id);
        $student_exam->stop_exam    = Carbon::now();
        
        $datetime1 = Carbon::parse($student_exam->start_exam);
        $datetime2 = Carbon::parse($student_exam->stop_exam);
        $interval = $datetime1->diff($datetime2);
        $student_exam->time_taken = $interval->format('%h:%i:%s');
        $student_exam->grade = $total_mark.' out of 100.00';
        $student_exam->total_mark = $total_mark;
        $student_exam->state = "Finish";
        $student_exam->save();

        return $student_exam;
    }

    public function deleteQuestion(Request $request)
    {
        $q_id = $request->id;
        $question = Question::find($q_id);

        QuestionAnswer::where('question_id', $question->id)->delete();
        $question->delete();

        return response()->json([
            'code'=>200,
        ]);
    }

    public function stopExam(Request $request)
    {
        $total_mark = StudentAnswer::where('course_id', $request->course_id)->where('module_id', $request->module_id)
        ->where('exam_id', $request->exam_id)->where('exam_by', Auth::id())->sum('mark');

        $exam = Exam::find($request->exam_id);
        $gradings = Grading::where('ref_no', $exam->grading_id)->get();

        foreach($gradings as $grading) {
            if($total_mark > $grading->grading_from && $total_mark < $grading->grading_to) {
                // dd($grading);
            }
        }

        $student_exam = StudentExam::find($request->student_exam);
        $student_exam->stop_exam    = Carbon::now();
        $student_exam->state        = "Finished";
        
        $datetime1 = Carbon::parse($student_exam->start_exam);
        $datetime2 = Carbon::parse($student_exam->stop_exam);
        $interval = $datetime1->diff($datetime2);
        $student_exam->time_taken = $interval->format('%h:%i:%s');
        $student_exam->grade = $total_mark.' out of 100.00';
        $student_exam->total_mark = $total_mark;
        $student_exam->save();

        $data['start_exam'] = date('l, d F Y, H:i A' ,strtotime($student_exam->start_exam));
        $data['stop_exam'] = date('l, d F Y, H:i A' ,strtotime($student_exam->stop_exam));
        $data['time_taken'] = $this->timeTaken($datetime1, $datetime2);

        return view('frontend.questions.exam_result', compact('exam','student_exam','data'));

        // return response()->json([
        //     'code' => 200,
        //     'student_exam' => $student_exam,
        //     'data' => $data,
        // ]);
    }

    public function examResult(Request $request, $exam_id)
    {
        $total_mark = StudentAnswer::where('course_id', $request->course_id)->where('module_id', $request->module_id)
        ->where('exam_id', $request->exam_id)->where('student_exam_id', $request->student_exam)->where('exam_by', Auth::id())->sum('mark');
        
        $exam = Exam::find($exam_id);
        if(empty($request->all())) {
            $slug = $exam->course->slug;
            return redirect('/my_courses/detail/'.$slug);
        }
        $gradings = Grading::where('ref_no', $exam->grading_id)->get();

        $mygrading = '';
        $grading_id = '';

        foreach($gradings as $grading) {
            if($total_mark >= $grading->grading_from && $total_mark <= $grading->grading_to) {
                $mygrading = $grading->grading_description;
                $grading_id = $grading->id;
            }
        }

        $student_exam = StudentExam::find($request->student_exam);
        $student_exam->stop_exam    = Carbon::now();
        $student_exam->state        = "Finished";
        
        $datetime1 = Carbon::parse($student_exam->start_exam);
        $datetime2 = Carbon::parse($student_exam->stop_exam);
        $interval = $datetime1->diff($datetime2);
        $student_exam->time_taken = $interval->format('%h:%i:%s');
        $student_exam->grade = (!empty($mygrading))? $mygrading : '';
        $student_exam->grade_id = (!empty($grading_id))? $grading_id : '';
        $student_exam->total_mark = $total_mark;
        $student_exam->save();

        // $data['start_exam'] = date('l, d F Y, H:i A' ,strtotime($student_exam->start_exam));
        // $data['stop_exam'] = date('l, d F Y, H:i A' ,strtotime($student_exam->stop_exam));
        $data['time_taken'] = $this->timeTaken($datetime1, $datetime2);

        return view('frontend.questions.exam_result', compact('exam','student_exam','data'));
    }

    public function downloadExamResult($student_exam_id)
    {
        $student_exam = StudentExam::find($student_exam_id);
        $exam = Exam::find($student_exam->exam_id);

        $datetime1 = Carbon::parse($student_exam->start_exam);
        $datetime2 = Carbon::parse($student_exam->stop_exam);
        $data['time_taken'] = $this->timeTaken($datetime1, $datetime2);

        $pdf = PDF::loadView('frontend.questions.exam_result_pdf', ['student_exam'=>$student_exam, 'exam'=>$exam,'data'=>$data]);
        return $pdf->download('PSM_exam_result.pdf');

    }

    public function numberStyle($number)
    {
        $data = "";

        if($number == 1) {
            $data = [
                1 => 'a.',
                2 => 'b.',
                3 => 'c.',
                4 => 'd.',
            ];
        }elseif($number == 2) {
            $data = [
                1 => 'A.',
                2 => 'B.',
                3 => 'C.',
                4 => 'D.',
            ];
        }elseif($number == 3) {
            $data = [
                1 => '1.',
                2 => '2.',
                3 => '3.',
                4 => '4.',
            ];
        }elseif($number == 4) {
            $data = [
                1 => 'i.',
                2 => 'ii.',
                3 => 'iii.',
                4 => 'iv.',
            ];
        }

        return $data;
    }

    public function timeTaken($start_date, $stop_date)
    {
        $datetime1 = $start_date;
        $datetime2 = $stop_date;
        $remain = "";
        $interval = $datetime1->diff($datetime2);
        $h = $interval->format('%h');
        $m = $interval->format('%i');
        $s = $interval->format('%s');
        
        if ($h > 0) {
            $remain .= $h ." hours ";
        }
        if ($m > 0) {
            $remain .= $m ." mins ";
        }
        if ($s > 0) {
            $remain .= $s ." secs ";
        }
        return $remain;
    }
}