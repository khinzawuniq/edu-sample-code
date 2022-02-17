<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\QuestionGroupName;
use Auth;

class BackendQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::OrderBy('id', 'DESC')->where('group_status', null)->get();
        return view('admin.questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $question_type  = $request->question_type;
        $group_names    = [''=>'Select Question Group']+QuestionGroupName::pluck('group_name','id')->toArray();
        return view('admin.questions.create', compact('question_type','group_names'));
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
        
        // $input = $request->except(['correct','choice']);
        // $input['created_by'] = Auth::id();
        // $question = Question::create($input);

        // if($question) {
        //     if($question->question_type == 'multiple_choice') {
        //         $numbering = $this->numberStyle($request->answer_no_style);

        //         for($i=0; count($request['choice']) > $i; $i++) {
        //             $choice['question_id'] = $question->id;
        //             $choice['answer'] = $request['choice'][$i];
        //             $choice['answer_no'] = $numbering[$i+1];
        //             QuestionAnswer::create($choice);
        //         }
        //     }
        // }

        flash('Question created successful!')->success()->important();
        return redirect()->route('backend-questions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function active($id)
    {

    }
}
