<?php

namespace App\Http\Controllers\Admin;

use App\Models\SlideShow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SlideShowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slideShows = SlideShow::All();

        return view('admin.slideshows.index', compact('slideShows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slideshows.create');
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
            'slide_photo' => 'required',
            'slide_name' => 'required',
        ]);

        $input = $request->except(['_token']);
        $input['is_active'] = 1;

        $slideShow = SlideShow::create($input);

        flash('SlideShow created successful!')->success()->important();
        return redirect('/admin/slideshows');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SlideShow  $slideShow
     * @return \Illuminate\Http\Response
     */
    public function show(SlideShow $slideShow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SlideShow  $slideShow
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slideShow = SlideShow::find($id);

        return view('admin.slideshows.edit', compact('slideShow'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SlideShow  $slideShow
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'slide_photo' => 'required',
            'slide_name' => 'required',
        ]);
        
        $input = $request->except(['_token','_method']);
        
        $slideShow = SlideShow::where('id', $id)->update($input);

        flash('SlideShow updated successful!')->success()->important();
        return redirect('/admin/slideshows');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SlideShow  $slideShow
     * @return \Illuminate\Http\Response
     */
    public function destroy(SlideShow $slideShow)
    {
        $slideShow->delete();
        flash('SlideShow deleted successful!')->success()->important();
        return redirect('/admin/slideshows');
    }

    public function active($id)
    {

    }
}
