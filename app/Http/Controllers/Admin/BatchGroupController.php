<?php

namespace App\Http\Controllers\Admin;

use App\Models\BatchGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Course;
use App\Models\CourseModule;
use App\Models\BatchGroupModule;
use Auth;
use DB;

class BatchGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($course_id)
    {
        $batchGroups = BatchGroup::where('course_id', $course_id)->orderBy('id','DESC')->get();

        $course = Course::find($course_id);
        $modules = CourseModule::where('course_id',$course_id)->orderBy('order_no')->get();

        return view('frontend.batch_groups.index', compact('batchGroups','course','modules','course_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($course_id)
    {
        $course = Course::find($course_id);
        $modules = CourseModule::where('course_id',$course_id)->orderBy('order_no')->get();

        return view('frontend.batch_groups.create', compact('course','modules'));
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
            'module_id.*' => 'required',
        ]);

        $input = $request->except(['_token']);
        $input['accessed_module_no'] = count($request['module_id']);
        $input['created_by'] = Auth::id();

        $batchGroup = BatchGroup::create($input);

        if($batchGroup) {
            if(isset($request['module_id'])) {
                for($i=0; $i < count($request['module_id']); $i++) {
                    $batch_module['batch_group_id'] = $batchGroup->id;
                    $batch_module['course_id']      = $request->course_id;
                    $batch_module['module_id']      = $request['module_id'][$i];
    
                    BatchGroupModule::create($batch_module);
                }
            }
        }

        flash('Batch Group Name '.$batchGroup->group_name.' created successful!')->success()->important();
    
        return redirect('/admin/batch_groups/'.$request->course_id);
        // return redirect('/courses/detail/'.$request->course_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BatchGroup  $batchGroup
     * @return \Illuminate\Http\Response
     */
    public function show(BatchGroup $batchGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BatchGroup  $batchGroup
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $course_id)
    {
        $batchGroup = BatchGroup::find($id);
        $batch_modules = $batchGroup->module;

        return response()->json([
            'code' => 200,
            'batch' => $batchGroup,
            'batch_modules'=> $batch_modules,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BatchGroup  $batchGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'group_name' => 'required',
            'module_id.*' => 'required',
        ]);

        // $input = $request->except(['_token','batch_id','batch_module_id','module_id']);
        $accessed_module_no = count($request['module_id']);

        $batchGroup = BatchGroup::find($request->batch_id);
        $batchGroup->group_name = $request->group_name;
        $batchGroup->accessed_module_no = $accessed_module_no;
        $batchGroup->save();

        $arrID = [];
        if($batchGroup) {
            if(isset($request['module_id'])) {
                for($i=0; $i < count($request['module_id']); $i++) {

                    if(isset($request['batch_module_id'][$i])) {
                        
                        $batch_module['batch_group_id'] = $batchGroup->id;
                        $batch_module['course_id']      = $request->course_id;
                        $batch_module['module_id']      = $request['module_id'][$i];

                        $update_batch_module = BatchGroupModule::where('id', $request['batch_module_id'][$i])->update($batch_module);
                        $arrID[] = $request['batch_module_id'][$i];
                    }else {
                        $batch_module['batch_group_id'] = $batchGroup->id;
                        $batch_module['course_id']      = $request->course_id;
                        $batch_module['module_id']      = $request['module_id'][$i];
        
                        $save_batch_module = BatchGroupModule::create($batch_module);
                        $arrID[] = $save_batch_module->id;
                    }

                }

                if (count($arrID) > 0)
                {
                    DB::table("batch_group_modules")->whereNotIn('id',$arrID)->where('batch_group_id','=',$batchGroup->id)->delete();
                }
            }
        }

        flash('Batch Group Name '.$batchGroup->group_name.' updated successful!')->success()->important();
    
        return redirect('/admin/batch_groups/'.$request->course_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BatchGroup  $batchGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(BatchGroup $batchGroup)
    {
        $course_id = $batchGroup->course_id;
        BatchGroupModule::where('batch_group_id', $batchGroup->id)->delete();
        $batchGroup->delete();
        return redirect('/admin/batch_groups/'.$course_id);
    }

}
