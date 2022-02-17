<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuestionGroupName;
use App\Models\Question;
use App\Models\QuestionAnswer;

class QuestionGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $question_groups = QuestionGroupName::Orderby('id','DESC')->get();

        return view('admin.question-groups.index', compact('question_groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.question-groups.create');
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

        flash('Question Group created successful!')->success()->important();
        return redirect()->route('question-groups.index');
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
        $question_group = QuestionGroupName::find($id);

        return view('admin.question-groups.edit', compact('question_group'));
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
            'group_name' => 'required',
        ]);

        $group_name = QuestionGroupName::where('id', $id)->update([
            'group_name' => $request->group_name,
        ]);

        flash('Question Group updated successful!')->success()->important();
        return redirect()->route('question-groups.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question_group = QuestionGroupName::find($id)->delete();
        flash('Question Group deleted successful!')->success()->important();
        return redirect()->route('question-groups.index');
    }

    public function active($id)
    {

    }
}
