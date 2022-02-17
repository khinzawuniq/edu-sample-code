<?php

namespace App\Http\Controllers\Admin;

use App\Models\StudentAnswer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionAnswer;
use Auth;

class StudentAnswerController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentAnswer  $studentAnswer
     * @return \Illuminate\Http\Response
     */
    public function show(StudentAnswer $studentAnswer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentAnswer  $studentAnswer
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentAnswer $studentAnswer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentAnswer  $studentAnswer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentAnswer $studentAnswer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentAnswer  $studentAnswer
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentAnswer $studentAnswer)
    {
        //
    }

    public function studentAnswer(Request $request)
    {
        $question_id    = $request->question_id;
        $question   = Question::find($question_id);

        if(isset($request->answer_id)) {
            $answer_id      = $request->answer_id;
            $answer     = QuestionAnswer::find($answer_id);
            $choice_answer_id = $answer->id;
            $choice_answer = $answer->answer;
            if($question->correct_answer == $answer->answer){
                $mark = $question->mark;
            }else {
                $mark = 0;
            }
        }

        if(isset($request->choice_answer)) {
            $choice_answer_id = 0;
            $choice_answer = $request->choice_answer;

            if($question->correct_answer == $choice_answer){
                $mark = $question->mark;
            }else {
                $mark = 0;
            }
        }

        if($request->student_answer_id == 0) {
            $studentAnswer = New StudentAnswer();
        }else {
            $studentAnswer = StudentAnswer::find($request->student_answer_id);
        }

        $studentAnswer->course_id = $question->course_id;
        $studentAnswer->module_id = $question->module_id;
        $studentAnswer->exam_id = $request->exam_id;
        $studentAnswer->question_id = $question->id;
        $studentAnswer->exam_by = Auth::id();
        $studentAnswer->choice_answer_id = $choice_answer_id;
        $studentAnswer->choice_answer = $choice_answer;
        $studentAnswer->mark = $mark;
        $studentAnswer->student_exam_id = $request->student_exam_id;
        $studentAnswer->save();

        return response()->json([
            'code' => 200,
            'studentAnswer' => $studentAnswer,
        ]);
    }
}
