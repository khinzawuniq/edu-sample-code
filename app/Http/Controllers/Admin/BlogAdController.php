<?php

namespace App\Http\Controllers\Admin;

use App\Models\BlogAd;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogAdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogAd = BlogAd::first();

        if(empty($blogAd)) {
            return view('admin.ads.create');
        }
        
        return view('admin.ads.edit', compact('blogAd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.ads.create');
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
            'ads_image'   => 'required',
            'ads_url'   => 'required',
        ]);

        $input = $request->except(['_token']);

        $blogAd = BlogAd::create($input);

        flash('Ads created successful!')->success()->important();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BlogAd  $blogAd
     * @return \Illuminate\Http\Response
     */
    public function show(BlogAd $blogAd)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BlogAd  $blogAd
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogAd $blogAd)
    {
        return view('admin.ads.edit', compact('blogAd'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BlogAd  $blogAd
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'ads_image'   => 'required',
            'ads_url'   => 'required',
        ]);
        
        $input = $request->except(['_token']);

        $blogAd = BlogAd::find($id);

        $blogAd->update($input);

        flash('Ads updated successful!')->success()->important();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlogAd  $blogAd
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogAd $blogAd)
    {
        //
    }
}
