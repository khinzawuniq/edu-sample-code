<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\CourseModule;
use App\Models\Course;
use Illuminate\Http\Request;
use Auth;
class CourseModuleController extends Controller
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
        $topic_count = $request->count;
        $course_id = $request->course_id;
        $count = CourseModule::where('course_id',$course_id)->count();
        if($count > 0){
            for ($i=1; $i <= $topic_count ; $i++) { 
                $name = "Unit-".($count+$i);
                $order_no = CourseModule::where('course_id',$course_id)->max('order_no')+1;
                CourseModule::create([
                    "name"=> $name,
                    "course_id" => $course_id,
                    "order_no" => $order_no,
                    "created_by" => Auth::id()
                ]);
            }
        }else{
            for ($i=1; $i <= $topic_count ; $i++) { 
                if ($i == 1) {
                    $name = "Course Overview";
                }else{
                    $name = "Unit-".($i-1);
                }

                CourseModule::create([
                    "name"=> $name,
                    "course_id" => $course_id,
                    "created_by" => Auth::id()
                ]);
            }
        }

        $course = Course::find($course_id);

        return redirect('/courses/detail/'.$course->slug);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CourseModule  $courseModule
     * @return \Illuminate\Http\Response
     */
    public function show(CourseModule $courseModule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CourseModule  $courseModule
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseModule $courseModule)
    {
        return view('frontend.modules.edit',compact('courseModule'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CourseModule  $courseModule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseModule $courseModule)
    {
        $type = $request->type;
        $courseModule->name = $request->name;
        $courseModule->save();

        if($type == "ajax"){
            return response()->json([
                "code" => 200,
                "message" => "Successfully updated!"
            ]);
        }
        return redirect('courses/detail/'.$courseModule->course->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CourseModule  $courseModule
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseModule $courseModule)
    {
        $slug = $courseModule->course->slug;
        $courseModule->lessons()->delete();
        $courseModule->delete();
        return redirect('courses/detail/'.$slug);
    }


    public function changeStatus($id)
    {
       $course_module = CourseModule::find($id);
       $status =  $course_module->is_active;
       $course_module->is_active = !$course_module->is_active;
       $course_module->save();
       $msg = "Module is successfully ".($status == 1 ? "unsuspended." : "suspended.");
       return response()->json([
           "code" => 200,
           "status" =>  $course_module->is_active,
           "message" => $msg
       ]);
    }
}
