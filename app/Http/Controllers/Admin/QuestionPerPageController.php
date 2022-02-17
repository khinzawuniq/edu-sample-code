<?php

namespace App\Http\Controllers\Admin;

use App\Models\QuestionPerPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionPerPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions_per_page = QuestionPerPage::get();
        return view('admin.question-per-pages.index', compact('questions_per_page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.question-per-pages.create');
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
            'question_per_page' => 'required',
            'description' => 'required',
        ]);

        $input = $request->all();

        QuestionPerPage::create($input);

        return redirect()->route('question-per-pages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuestionPerPage  $questionPerPage
     * @return \Illuminate\Http\Response
     */
    public function show(QuestionPerPage $questionPerPage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuestionPerPage  $questionPerPage
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionPerPage $questionPerPage)
    {
        return view('admin.question-per-pages.edit', compact('questionPerPage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuestionPerPage  $questionPerPage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuestionPerPage $questionPerPage)
    {
        $this->validate($request, [
            'question_per_page' => 'required',
            'description' => 'required',
        ]);

        $input = $request->all();

        $questionPerPage::create($input);

        return redirect()->route('question-per-pages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuestionPerPage  $questionPerPage
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionPerPage $questionPerPage)
    {
        $questionPerPage->delete();
        flash('Questions Per Page deleted successful!')->success()->important();
        return redirect(route('question-per-pages.index'));
    }

    public function statusChange($id)
    {
        $questionPerPage = QuestionPerPage::find($id);
        $status =  $questionPerPage->is_active;
        $questionPerPage->is_active = !$questionPerPage->is_active;
        $questionPerPage->save();
       
        return response()->json([
            "code" => 200,
            "status" =>  $questionPerPage->is_active,
        ]);
    }
}
