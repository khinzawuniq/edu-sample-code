<?php

namespace App\Http\Controllers\Admin;

use App\Models\EnrolUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Course;
use App\Models\BatchGroup;

class EnrolUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $enroll_users = EnrolUser::orderBy('id','DESC')->get();
        
        return view('admin.enroll_users.index',compact('enroll_users'));
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
            'enrole_users'  => 'required',
        ]);

        $enrol_count = EnrolUser::where('course_id', $request['course_id'])->count();
        $course = Course::find($request['course_id']);
        
        for($i=0;$i < count($request['enrole_users']); $i++) {
            
            if($request['enrole_users'][$i] == 'all') {
                $enrol_users = EnrolUser::join('users','users.id','=','enrol_users.user_id')
                ->where('course_id', $request['course_id'])->pluck('enrol_users.user_id');

                $users = User::where('role', 'Student')->whereNotIn('id', $enrol_users)->get();
                foreach($users as $key=>$user) {
                    $increase = $key+1;
                    $num = $enrol_count + $increase;
                    $enrole['serial_no'] = 'PSM-'.$course->course_code.'-'.$this->generate_numbers((int) $num, 1, 4);

                    if (!$request->is_limited) {
                        $request['start_date'] = null;
                        $request['end_date'] = null;
                    }

                    if(isset($request->batch_group_id)) {
                        $enrole['batch_group_id'] = $request->batch_group_id;
                    }
        
                    $enrole['user_id']      = $user->id;
                    $enrole['course_id']    = $request['course_id'];
                    $enrole['start_date']   = $request['start_date'];
                    $enrole['end_date']     = $request['end_date'];
                    $enrole['time_limit']   = ($request['time_limit'])? $request['time_limit'] : 0;
                    $enrole['time_type']    = ($request['time_type'])? $request['time_type'] : 0;
        
                    EnrolUser::create($enrole);
                }
            }else {
                $check_group = explode('-', $request['enrole_users'][$i]);
                
                if(count($check_group) > 1) {
                    // dd('A');
                    $groups = EnrolUser::where('course_id', $check_group[0])->whereNull('deleted_at')->get();
                    foreach($groups as $key=>$group) {
                        $increase = $key+1;
                        $num = $enrol_count + $increase;
                        $enrole['serial_no'] = 'PSM-'.$course->course_code.'-'.$this->generate_numbers((int) $num, 1, 4);

                        if (!$request->is_limited) {
                            $request['start_date'] = null;
                            $request['end_date'] = null;
                        }

                        if(isset($request->batch_group_id)) {
                            $enrole['batch_group_id'] = $request->batch_group_id;
                        }
            
                        $enrole['user_id']      = $group->user_id;
                        $enrole['course_id']    = $request['course_id'];
                        $enrole['start_date']   = $request['start_date'];
                        $enrole['end_date']     = $request['end_date'];
                        $enrole['time_limit']   = ($request['time_limit'])? $request['time_limit'] : 0;
                        $enrole['time_type']    = ($request['time_type'])? $request['time_type'] : 0;
            
                        EnrolUser::create($enrole);
                    }
                }else {
                    // dd('B');
                    $num = $enrol_count + 1;
                    $enrole['serial_no'] = 'PSM-'.$course->course_code.'-'.$this->generate_numbers((int) $num, 1, 4);

                    if (!$request->is_limited) {
                        $request['start_date'] = null;
                        $request['end_date'] = null;
                    }

                    if(isset($request->batch_group_id)) {
                        $enrole['batch_group_id'] = $request->batch_group_id;
                    }
        
                    $enrole['user_id']      = $request['enrole_users'][$i];
                    $enrole['course_id']    = $request['course_id'];
                    $enrole['start_date']   = $request['start_date'];
                    $enrole['end_date']     = $request['end_date'];
                    $enrole['time_limit']   = ($request['time_limit'])? $request['time_limit'] : 0;
                    $enrole['time_type']    = ($request['time_type'])? $request['time_type'] : 0;
                    // $enrole['duration']     = $request['duration'];
        
                    EnrolUser::create($enrole);
                }   
            }
        }

        flash('Enrol User created successful!')->success()->important();
        return redirect()->Back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\EnrolUser  $enrolUser
     * @return \Illuminate\Http\Response
     */
    public function show(EnrolUser $enrolUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\EnrolUser  $enrolUser
     * @return \Illuminate\Http\Response
     */
    public function edit(EnrolUser $enrolUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\EnrolUser  $enrolUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EnrolUser $enrolUser)
    {
        // $enrolUser->delete();

        // return response()->json([
        //     'code'  => 200,
        //     'enrol' => $enrolUser,
        // ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\EnrolUser  $enrolUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(EnrolUser $enrolUser)
    {
        //
    }

    public function getEnrol(Request $request)
    {
        $id = $request->enrol_id;
        $enrol = EnrolUser::find($id);
        $enrol->user_name = $enrol->user->name;
        $enrol->start_date = ($enrol->start_date)? date('Y-m-d', strtotime($enrol->start_date)) : '';
        $enrol->end_date = ($enrol->end_date)? date('Y-m-d', strtotime($enrol->end_date)) : '';
        $enrol->created_date = date('l, d F Y, H:i A', strtotime($enrol->created_at));
        
        return response()->json([
                'code'  => 200,
                'enrol' => $enrol,
            ]);
    }

    public function enrolUpdate(Request $request)
    {
        EnrolUser::where('id', $request->enrol_user_id)->update([
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'time_limit'    => $request->time_limit,
            'time_type'     => $request->time_type,
            
            // 'duration'      => $request->duration,
        ]);

        flash('Enrol User updated successful!')->success()->important();
        return redirect()->route('courses.enrol-user', $request->course_id);
    }

    public function unEnrolUser($id)
    {
        $unenrole_user = EnrolUser::find($id);
        $unenrole_user->delete();
        
        return response()->json([
            'code'  => 200,
            'unenrole_user' => $unenrole_user,
        ]);
    }

    public function active($id)
    {
        EnrolUser::where('id', $id)->update([
            'is_active' => true
        ]);
        return response()->json([
            'code' => 200,
            'message' => 'Successful Active',
        ]);
    }
    
    public function inactive($id)
    {
        EnrolUser::where('id', $id)->update([
            'is_active' => false
        ]);
        return response()->json([
            'code' => 200,
            'message' => 'Successful Inactive',
        ]);
    }

    public function generate_numbers($start, $count, $digits) {

		for ($n = $start; $n < $start+$count; $n++) {

			$result = str_pad($n, $digits, "0", STR_PAD_LEFT);

		}
		return $result;
	}

    public function updateSerialNo($course_id)
    {
        $course = Course::find($course_id);
        

        $enrols = EnrolUser::where('course_id', $course_id)->get();

        if(count($enrols) > 0) {
            foreach($enrols as $key=>$enrol) {
                $num = $key+1;
                $serial_no = 'PSM-'.$course->course_code.'-'.$this->generate_numbers((int) $num, 1, 4);
                $enrol->serial_no = $serial_no;
                $enrol->save();
            }
        }

        return false;
    }

    public function assignBatchGroup(Request $request)
    {
        $this->validate($request, [
            'batch_group_id'  => 'required',
        ]);

        $enrol_user = EnrolUser::find($request->enrol_user_id);
        if($enrol_user) {
            $enrol_user->batch_group_id = $request->batch_group_id;
            $enrol_user->save();
        }

        flash($enrol_user->user->name.' assign batch group successful!')->success()->important();
        return redirect()->route('courses.enrol-user', $request->course_id);
    }
    
    public function updateBatchGroup(Request $request)
    {
        $this->validate($request, [
            'batch_group_id'  => 'required',
        ]);

        $enrol_user = EnrolUser::find($request->enrol_user_id);

        if($enrol_user) {
            $enrol_user->batch_group_id = $request->batch_group_id;
            $enrol_user->save();
        }

        flash($enrol_user->user->name.' update batch group successful!')->success()->important();
        return redirect()->route('courses.enrol-user', $request->course_id);
    }

    public function applyGroup(Request $request, $course_id)
    {
        $ids = $request->ids;
        
        $students = EnrolUser::whereIn('id', explode(",", $ids))->update([
            'batch_group_id' => $request->batch_group_id,
        ]);

        return response()->json([
            'code' => 200,
        ]);
    }

    public function filterGroup(Request $request, $course_id)
    {
        $enroll_users = EnrolUser::orderBy('id','DESC')->get();
        return redirect()->route('courses.enrol-user', $request->course_id);
    }
}
