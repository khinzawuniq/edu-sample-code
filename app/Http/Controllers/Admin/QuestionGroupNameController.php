<?php

namespace App\Http\Controllers\Admin;

use App\Models\QuestionGroupName;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\AssignQuestion;
use App\Models\Course;

class QuestionGroupNameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $course_id = $request->course_id;
        $course = Course::find($request->course_id);
        $group_names = QuestionGroupName::orderBy('id','DESC')->get();

        return view('frontend.question_group_names.index', compact('group_names','course'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $course = Course::find($request->course_id);
        return view('frontend.question_group_names.create', compact('course'));
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
            'group_name' => 'required',
        ]);

        $group_name = QuestionGroupName::create([
            'group_name' => $request->group_name,
        ]);

        $course = Course::find($request->course_id);

        return redirect('/courses/detail/'.$course->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuestionGroupName  $questionGroupName
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, QuestionGroupName $questionGroupName)
    {
        $questions = $questionGroupName->questions;
        $change_question_groups = [''=>'Select Change Group']+QuestionGroupName::pluck('group_name','id')->toArray();
        $data['course_id'] = $request->course_id;
        // dd($questions);
        return view('frontend.question_group_names.group_detail', compact('questionGroupName', 'questions','change_question_groups','data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuestionGroupName  $questionGroupName
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionGroupName $questionGroupName)
    {
        return response()->json([
            'code' => 200,
            'group' => $questionGroupName,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuestionGroupName  $questionGroupName
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuestionGroupName $questionGroupName)
    {
        // $group_name = 
        $questionGroupName->group_name = $request->group_name;
        $questionGroupName->save();

        return response()->json([
            'code' => 200,
            'group' => $questionGroupName,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuestionGroupName  $questionGroupName
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionGroupName $questionGroupName)
    {
        $group_id = $questionGroupName->id;
        $questions = Question::where('question_group_name', $group_id)->get();
        foreach($questions as $question) {
            QuestionAnswer::where('question_id', $question->id)->delete();
            $question->delete();
        }
        $questionGroupName->delete();

        return redirect()->back();
    }

    public function storeGroup(Request $request)
    {
        $group_name = QuestionGroupName::create([
            'group_name' => $request->group_name,
        ]);

        return response()->json([
            'code' => 200,
            'group' => $group_name,
        ]);
    }

    public function selectGroup(Request $request, $id)
    {
        $data['group_id']   = $id;
        $data['course_id']  = $request->course_id;
        $data['module_id']  = $request->module_id;
        $data['exam_id']    = $request->exam_id;

        $questions = Question::where('question_group_id', $id)->get();

        $course = Course::find($request->course_id);

        return view('frontend.question_group_names.select_group',compact('data','questions', 'course'));

    }

    public function saveQuestions(Request $request, $id)
    {
        $ids = $request->ids;

        // $questions = Question::whereIn('id', explode(",", $ids))->update([
        //     'course_id' => $request->course_id,
        //     'module_id' => $request->module_id,
        //     'exam_id' => $request->exam_id,
        // ]);
        
        foreach(explode(",", $ids) as $qid) {
            
            $assign_question = AssignQuestion::where('course_id', $request->course_id)->where('module_id', $request->module_id)
            ->where('exam_id', $request->exam_id)->where('group_id', $id)->where('question_id', $qid)->first();

            if(empty($assign_question)) {
                $assigns                = New AssignQuestion();
                $assigns->course_id     = $request->course_id;
                $assigns->module_id     = $request->module_id;
                $assigns->exam_id       = $request->exam_id;
                $assigns->group_id      = $id;
                $assigns->question_id   = $qid;
                $assigns->save();
            }
            
        }

        return response()->json([
            'code'      => 200,
        ]);
    }
}
