<?php

namespace App\Http\Controllers\Admin;

use App\Models\Grading;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class GradingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gradings = Grading::get();
        $grading_group = Grading::orderBy('id','DESC')->select('ref_no', 'awarding_body','grading_from','grading_to','grading_description','is_active','passing_mark','number_grading')->groupBy('ref_no')->get();
        
        return view('admin.gradings.index', compact('gradings','grading_group'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.gradings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd(count($request['grading_description']));
        $this->validate($request, [
            'awarding_body'=> 'required',
            'passing_mark'=> 'required',
            'grading_description' => 'required',
        ]);

        $grade_count = Grading::groupBy('ref_no')->get();
        // dd(count($grade_count));
        if (count($grade_count) != 0) {
			$ref_no = count($grade_count) + 1;
		} else {
			$ref_no = 1;
		}

        if(count($request['grading_description']) > 0) {
            for($i=0; $i < count($request['grading_description']); $i++) {
                if(!empty($request['grading_description'][$i]) && !empty($request['grading_to'][$i])) {
                    $grading['ref_no']          = $ref_no;
                    $grading['awarding_body']   = $request->awarding_body;
                    $grading['number_grading']  = $request->number_grading;
                    $grading['passing_mark']    = $request->passing_mark;
                    $grading['grading_from']    = ($request['grading_from'][$i])? $request['grading_from'][$i] : 0;
                    $grading['grading_to']      = $request['grading_to'][$i];
                    $grading['grading_description'] = $request['grading_description'][$i];
    
                    Grading::create($grading);
                }
            }
        }

        return redirect()->route('gradings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grading  $grading
     * @return \Illuminate\Http\Response
     */
    public function show(Grading $grading)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grading  $grading
     * @return \Illuminate\Http\Response
     */
    public function edit($ref_no)
    {
        $gradings = Grading::where('ref_no', $ref_no)->get();
        return view('admin.gradings.edit', compact('gradings', 'ref_no'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grading  $grading
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $ref_no)
    {
        $this->validate($request, [
            'awarding_body'=> 'required',
            'grading_description' => 'required',
        ]);

        $arrID = [];
        
        for($i=0; $i < count($request['grading_description']); $i++) {
            if(isset($request['grading_id'][$i])) {
                $grading['awarding_body']   = $request->awarding_body;
                $grading['number_grading']  = $request->number_grading;
                $grading['passing_mark']    = $request->passing_mark;
                $grading['grading_from']    = $request['grading_from'][$i];
                $grading['grading_to']      = $request['grading_to'][$i];
                $grading['grading_description'] = $request['grading_description'][$i];

                $update_grading = Grading::where('id', $request['grading_id'][$i])->update($grading);
                $arrID[] = $request['grading_id'][$i];
            }else {
                if(!empty($request['grading_description'][$i])) {
                    $grading['ref_no']          = $ref_no;
                    $grading['awarding_body']   = $request->awarding_body;
                    $grading['number_grading']  = $request->number_grading;
                    $grading['passing_mark']    = $request->passing_mark;
                    $grading['grading_from']    = (!empty($request['grading_from'][$i]))? $request['grading_from'][$i] : 0;
                    $grading['grading_to']      = $request['grading_to'][$i];
                    $grading['grading_description'] = $request['grading_description'][$i];
                    
                    $grading_create = Grading::create($grading);
                    $arrID[] = $grading_create->id;
                }
            }
        }

        if (count($arrID) > 0)
        {
            DB::table("gradings")->whereNotIn('id',$arrID)->where('ref_no', $ref_no)->delete();
        }

        return redirect()->route('gradings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grading  $grading
     * @return \Illuminate\Http\Response
     */
    public function destroy($ref_no)
    {
        Grading::where('ref_no', $ref_no)->delete();

        flash('Grading deleted successful!')->success()->important();
        return redirect(route('gradings.index'));
    }

    public function statusChange($ref_no)
    {
        $gradings = Grading::where('ref_no', $ref_no)->get();

        foreach($gradings as $grading) {
            $status =  $grading->is_active;
            $grading->is_active = !$grading->is_active;
            $grading->save();
        }
       
        return response()->json([
            "code" => 200,
            "status" =>  $status,
        ]);
    }

    public function getGrading(Request $request)
    {
        $grading = Grading::where('ref_no', $request->ref_no)->first();
        return response()->json($grading);
    }

    public function generate_numbers($start, $count, $digits) {

		for ($n = $start; $n < $start + $count; $n++) {

			$result = str_pad($n, $digits, "0", STR_PAD_LEFT);

		}
		return $result;
	}
}
