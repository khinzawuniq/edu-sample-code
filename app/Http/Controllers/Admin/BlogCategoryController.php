<?php

namespace App\Http\Controllers\Admin;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogCategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        $categories = BlogCategory::orderBy('id','desc')->get();

        return view('admin.blog_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blog_categories.create');
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
            'category_name'   => 'required',
        ]);

        $input = $request->except(['_token']);
        $input['created_by'] = auth()->user()->id;

        $blogCategory = BlogCategory::create($input);

        flash('Blog Category created successful!')->success()->important();
        return redirect('/admin/blog-categories');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function show(BlogCategory $blogCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogCategory $blogCategory)
    {
        return view('admin.blog_categories.edit', compact('blogCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogCategory $blogCategory)
    {
        $this->validate($request, [
            'category_name'   => 'required',
        ]);

        $input = $request->except(['_token']);
        $input['updated_by'] = auth()->user()->id;

        $blogCategory->update($input);

        flash('Blog Category updated successful!')->success()->important();
        return redirect('/admin/blog-categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogCategory $blogCategory)
    {
        $blogCategory->delete();

        flash('Blog Category deleted successful!')->success()->important();
        return redirect('/admin/blog-categories');
    }

    public function active($id)
    {
        BlogCategory::where('id', $id)->update([
            'is_active' => true
        ]);
        return response()->json([
            'code' => 200,
            'message' => 'Successful Active',
        ]);
    }
    
    public function inactive($id)
    {
        BlogCategory::where('id', $id)->update([
            'is_active' => false
        ]);
        return response()->json([
            'code' => 200,
            'message' => 'Successful Inactive',
        ]);
    }
}
