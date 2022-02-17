<?php

namespace App\Http\Controllers\Admin;

use App\Models\StudentPayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EnrolUser;
use App\User;
use App\Models\Course;
use Hash;
use Mail;
use App\Mail\InformRegistration;
use App\Models\PaymentDescription;
use App\Models\BatchGroup;

class StudentPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = '';
        $studentPayments = StudentPayment::orderBy('id','DESC');
        if(isset($request->approve_status)) {
            $status = $request->approve_status;
            if($request->approve_status != "all") {
                $studentPayments = $studentPayments->where('approve_status', '=',$request->approve_status);
            }
        }
        $studentPayments = $studentPayments->get();

        return view('admin.payments.index', compact('studentPayments','status'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentPayment  $studentPayment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $firstPayment = StudentPayment::first();
        $studentPayment = StudentPayment::find($id);
        
        if(empty($studentPayment)) {
            if($firstPayment->id > $id) {
                return redirect(route('payments.index'));
            }else {
                $previous = StudentPayment::where('id','<',$id)->max('id');
                $studentPayment = StudentPayment::find($previous);
            }
        }

        $batch_groups = BatchGroup::where('course_id', $studentPayment->course_id)->pluck('group_name','id')->toArray();
        
        return view('admin.payments.show',compact('studentPayment','batch_groups'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentPayment  $studentPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentPayment $studentPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentPayment  $studentPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentPayment $studentPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentPayment  $studentPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        StudentPayment::find($id)->delete();

        flash('Student payment deleted successful!')->success()->important();
        return redirect(route('payments.index'));
    }

    public function approve(Request $request, $id)
    {
        $studentPayment = StudentPayment::find($id);
        $student = User::where('id', $studentPayment->student_id)->orWhere('email', $studentPayment->email)->first();

        $enrol_count = EnrolUser::where('course_id', $studentPayment->course_id)->count();
        $course = Course::find($studentPayment->course_id);

        if($student) {
    
            $enrol_course = EnrolUser::where('user_id', $student->id)->where('course_id', $studentPayment->course_id)->first();

            if(empty($enrol_course)) {                

                $num = $enrol_count + 1;
                $enrole['serial_no'] = 'PSM-'.$course->course_code.'-'.$this->generate_numbers((int) $num, 1, 4);

                $enrole['user_id']      = $student->id;
                $enrole['course_id']    = $studentPayment->course_id;
                $enrole['batch_group_id']    = ($request->batch_group_id)? $request->batch_group_id : null;
                $enrole['payment_status']    = 4;
                $enrole['slip']         = $studentPayment->payment_screenshot;
                $enrole['status']       = 'payment';
                $enrole['start_date']   = null;
                $enrole['end_date']     = null;
                $enrole['time_limit']   = 0;
                $enrole['time_type']    = 0;
                $enrole['pay_status']   = 1;
                $enrole['is_active']    = 1;
        
                EnrolUser::create($enrole);

            }else {
                if(empty($enrol_course->batch_group_id)) {
                    $enrol_course->batch_group_id = ($request->batch_group_id)? $request->batch_group_id : null;;
                }
                $enrol_course->payment_status = 4;
                $enrol_course->status = 'payment';
                $enrol_course->pay_status = 1;
                $enrol_course->is_active = 1;
                $enrol_course->save();
            }
            
        }else {

            $input['name']  = $studentPayment->name;
            $input['email'] = $studentPayment->email;
            $input['phone'] = $studentPayment->phone;

            $input['password_change'] = 0;
            $input['password']  = Hash::make("PsmLms123$");
            $password           = "PsmLms123$";

            $user = User::create($input);

            $user->assignRole('Student');

            if(!empty($user)) {

                $num = $enrol_count + 1;
                $enrole['serial_no'] = 'PSM-'.$course->course_code.'-'.$this->generate_numbers((int) $num, 1, 4);
        
                $enrole['user_id']      = $user->id;
                $enrole['course_id']    = $studentPayment->course_id;
                $enrole['batch_group_id']    = ($request->batch_group_id)? $request->batch_group_id : null;;
                $enrole['payment_status']    = 4;
                $enrole['slip']         = $studentPayment->payment_screenshot;
                $enrole['status']       = 'payment';
                $enrole['start_date']   = null;
                $enrole['end_date']     = null;
                $enrole['time_limit']   = 0;
                $enrole['time_type']    = 0;
                $enrole['pay_status']    = 1;
                $enrole['is_active']    = 1;
        
                EnrolUser::create($enrole);

                
                $emails = [$user->email];
                Mail::to($emails)
                ->send(new InformRegistration($user, $password));
            }
        }
        

        $studentPayment->approve_status = 1;
        $studentPayment->save();

        flash('Successful payment approve for '. $studentPayment->name.'.')->success()->important();
        if(isset($request->next)) {
            $next = $studentPayment->id-1;
            $firstPayment = StudentPayment::first();
            $studentPayment = StudentPayment::find($next);
            
            if(empty($studentPayment)) {
                if($firstPayment->id > $next) {
                    return redirect(route('payments.index'));
                }else {
                    $previous = StudentPayment::where('id','<',$next)->max('id');
                    $studentPayment = StudentPayment::find($previous);
                }
            }

            return redirect()->route('payments.show', $next);
        }else {
            return redirect()->route('payments.index');
        }
    }

    public function generate_numbers($start, $count, $digits) {

		for ($n = $start; $n < $start+$count; $n++) {

			$result = str_pad($n, $digits, "0", STR_PAD_LEFT);

		}
		return $result;
	}
    
}
