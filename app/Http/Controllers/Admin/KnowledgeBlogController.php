<?php

namespace App\Http\Controllers\Admin;

use App\Models\KnowledgeBlog;
use App\Models\BlogAttachment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;

class KnowledgeBlogController extends Controller
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
        $blogs = KnowledgeBlog::orderBy('id', 'desc')->get();

        return view('admin.knowledge_blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = BlogCategory::pluck('category_name','id')->toArray();
        return view('admin.knowledge_blogs.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'title'   => 'required',
        ]);

        $input = $request->except(['_token']);

        $title = strtolower($request->title);
        $input['slug'] = str_replace(" ", "-", $title);

        $knowledgeBlog = KnowledgeBlog::create($input);

        // if($knowledgeBlog) {
        //     for($i=0; $i < $request['file_count']; $i++) {
        //         if(!empty($request['attachment'][$i])) {
        //             $att['knowledge_blog_id']   = $knowledgeBlog->id;
        //             $att['attachment']          = $request['attachment'][$i];
    
        //             BlogAttachment::create($att);
        //         }
        //     }
        // }

        flash('Knowledge Blog '.$knowledgeBlog->title.' created successful!')->success()->important();

        return redirect('/admin/knowledge-blogs');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KnowledgeBlog  $knowledgeBlog
     * @return \Illuminate\Http\Response
     */
    public function show(KnowledgeBlog $knowledgeBlog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KnowledgeBlog  $knowledgeBlog
     * @return \Illuminate\Http\Response
     */
    public function edit(KnowledgeBlog $knowledgeBlog)
    {
        $categories = BlogCategory::pluck('category_name','id')->toArray();

        return view('admin.knowledge_blogs.edit', compact('knowledgeBlog','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KnowledgeBlog  $knowledgeBlog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KnowledgeBlog $knowledgeBlog)
    {
        $this->validate($request, [
            'title'   => 'required',
        ]);

        $input = $request->except(['_token']);
        $title = strtolower($request->title);
        $input['slug'] = str_replace(" ", "-", $title);

        $knowledgeBlog->update($input);

        // if($knowledgeBlog) {
        //     for($i=0; $i < $request['file_count']; $i++) {
        //         if(!empty($request['attachment'][$i])) {
        //             $att['knowledge_blog_id']   = $knowledgeBlog->id;
        //             $att['attachment']          = $request['attachment'][$i];
    
        //             BlogAttachment::create($att);
        //         }
        //     }
        // }

        flash('Knowledge Blog '.$knowledgeBlog->title.' created successful!')->success()->important();

        return redirect('/admin/knowledge-blogs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KnowledgeBlog  $knowledgeBlog
     * @return \Illuminate\Http\Response
     */
    public function destroy(KnowledgeBlog $knowledgeBlog)
    {
        $blog_title = $knowledgeBlog->title;

        BlogAttachment::where('knowledge_blog_id', $knowledgeBlog->id)->delete();

        $knowledgeBlog->delete();

        flash('Knowledge Blog '.$blog_title.' created successful!')->success()->important();

        return redirect('/admin/knowledge-blogs');
    }

    public function active($id)
    {
        KnowledgeBlog::where('id', $id)->update([
            'is_active' => true
        ]);
        return response()->json([
            'code' => 200,
            'message' => 'Successful Active',
        ]);
    }
    
    public function inactive($id)
    {
        KnowledgeBlog::where('id', $id)->update([
            'is_active' => false
        ]);
        return response()->json([
            'code' => 200,
            'message' => 'Successful Inactive',
        ]);
    }
}
