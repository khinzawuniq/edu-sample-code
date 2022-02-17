<?php

namespace App\Http\Controllers\Admin;

use App\Models\FAQ;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class FAQController extends Controller
{

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
        // return view('frontend.faq');
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
        $this->validate($request, [
            'question' => 'required',
            'answer' => 'required',
        ]);

        $input = $request->except(['_token']);
        $input['created_by'] = Auth::id();

        $faq = FAQ::create($input);

        flash('FAQ created successful!')->success()->important();
        return redirect('/faq');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FAQ  $fAQ
     * @return \Illuminate\Http\Response
     */
    public function show(FAQ $fAQ)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FAQ  $fAQ
     * @return \Illuminate\Http\Response
     */
    public function edit(FAQ $fAQ)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FAQ  $fAQ
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FAQ $fAQ)
    {
        //
    }
    
    public function updateFAQ(Request $request)
    {
        $this->validate($request, [
            'question' => 'required',
            'answer' => 'required',
        ]);

        $input = $request->except(['_token','faq_id','files']);
        
        $faq = FAQ::where('id', $request->faq_id)->update($input);

        flash('FAQ updated successful!')->success()->important();
        return redirect('/faq');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FAQ  $fAQ
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faq = FAQ::find($id)->delete();

        return response('success');
    }

    public function getFAQ($id)
    {
        $faq = FAQ::find($id);

        return response($faq);
    }

    public function deleteFAQ($id)
    {
        $faq = FAQ::find($id)->delete();

        return response('success');
    }
}
