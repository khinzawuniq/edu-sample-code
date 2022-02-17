<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\CourseCategory;
use App\Models\Course;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Image;
class CourseCategoryController extends Controller
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
        $user = User::find(Auth::id());
        if($user->hasRole(['Student'])) {
            return redirect('/home');
        }
        $categories = CourseCategory::orderBy('order_no')->get();
        $courses = Course::orderBy('order_no')->get();

        $copycategories = CourseCategory::pluck('name','id')->toArray();

        return view('admin.course_category.index',compact('categories','courses','copycategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.course_category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $data = $request->except(['_token','photo']);
       $data['is_active'] =1;
       $data['created_by'] = Auth::id();
       $title = strtolower($request->name);
       $data['slug'] = str_replace(" ", "-", $title);
    //    if(isset($request->photo)) {
    //         $photo = $_FILES['photo'];
    //         if(!empty($photo['name'])){
    //             $file_name = 'image_'.time().'.'.$request->file('photo')->guessExtension();
    //             $tmp_file = $photo['tmp_name'];
    //             $img = Image::make($tmp_file);
            
    //             $img->resize(600, 600)->save(public_path('/uploads/category_images/'.$file_name));
    //             $data['image'] = $file_name;
    //         }
    //     }
       $category = CourseCategory::create($data);

       return redirect(route('course_categories.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CourseCategory  $courseCategory
     * @return \Illuminate\Http\Response
     */
    public function show(CourseCategory $courseCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CourseCategory  $courseCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseCategory $courseCategory)
    {
        return view('admin.course_category.edit',compact('courseCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CourseCategory  $courseCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseCategory $courseCategory)
    {
        $data = $request->except('_token');
        // $data['is_active'] = $request->is_active ? false : true;
        $title = strtolower($request->name);
        $data['slug'] = str_replace(" ", "-", $title);
        
        $courseCategory->update($data);

        return redirect(route('course_categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourseCategory  $courseCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseCategory $courseCategory)
    {
        if(count($courseCategory->courses) > 0) {
            $courseCategory->courses->delete();
        }
        
        $courseCategory->delete();
        
        return redirect(route('course_categories.index'));
    }


    public function changeStatus($id)
    {
       $category = CourseCategory::find($id);
       $status =  $category->is_active;
       $category->is_active = !$category->is_active;
       $category->save();
       $msg = "Course Category is successfully ".($status == 1 ? "unsuspended." : "suspended.");
       return response()->json([
           "code" => 200,
           "status" =>  $category->is_active,
           "message" => $msg
       ]);
    }

    public function moveCategory(Request $request)
    {
       $category_ids = json_decode($request->category_ids);
       $parent_id = $request->parent_id;
       if(in_array($parent_id,$category_ids)){
           unset($category_ids[array_search($parent_id, $category_ids)]);
       }
       $categories = CourseCategory::whereIn('id',$category_ids)->update(['parent_id'=> $parent_id]);
       return redirect(route('course_categories.index'));
    }
}
