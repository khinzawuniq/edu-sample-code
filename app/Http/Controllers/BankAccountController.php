<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use Auth;
use Image;
use App\User;
use App\Models\StudentPayment;
use App\Models\Course;
use App\Models\PaymentDescription;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $bankAccounts = BankAccount::where('bank_name', '!=','By Cash')->get();

        $courses = Course::pluck('course_name','id')->toArray();
        $banks = BankAccount::pluck('bank_name','id')->toArray();

        $pay_types = PaymentDescription::get();
        $pays = PaymentDescription::pluck('pay_name','id')->toArray();

        $user = '';
        if(Auth::check()) {
            $user = User::find(auth()->user()->id);
        }

        $course_id = '';
        if(isset($request->course_id)) {
            $course_id = $request->course_id;
        }

        return view('frontend.bank_accounts.payment', compact('bankAccounts','courses','banks','pay_types','pays','user','course_id'));
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
            'bank_name'     => 'required',
            'bank_account'  => 'required',
            'bank_logo'     => 'required',
        ]);

        $data = $request->except('_token');
        $data['created_by'] = Auth::id();
        $bankAccount = BankAccount::create($data);

        return redirect('/payments');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function show(BankAccount $bankAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bankAccount = BankAccount::find($id);

        return response($bankAccount);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'bank_id'       => 'required',
            'bank_name'     => 'required',
            'bank_account'  => 'required',
            'bank_logo'     => 'required',
        ]);

        $bankAccount = BankAccount::find($request->bank_id);

        $bankAccount->bank_name = $request->bank_name;
        $bankAccount->bank_account = $request->bank_account;
        $bankAccount->bank_user = ($request->bank_user)? $request->bank_user:null;
        $bankAccount->additional_note = ($request->additional_note)? $request->additional_note:null;
        $bankAccount->bank_logo = ($request->bank_logo)? $request->bank_logo:$bankAccount->bank_logo;
        $bankAccount->updated_by = Auth::id();
        $bankAccount->save();

        flash('Bank Account Updated Successful!')->success()->important();
        return redirect('/payments');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        BankAccount::find($request->id)->delete();

        return response($request->id);
    }

    public function paymentUpload(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'course_id' => 'required',
            'payment_type' => 'required',
            'payment_description' => 'required',
            'payment_screenshot' => 'required',
        ]);

        if(Auth::check()) {
            $student_id = Auth::Id();
        }else {
            $student_id = 0;
        }

        $payment = New StudentPayment();
        $payment->name = $request->name;
        $payment->email = $request->email;
        $payment->phone = $request->phone;
        $payment->course_id = $request->course_id;
        $payment->payment_type = $request->payment_type;
        $payment->payment_description = $request->payment_description;
        $payment->installment_time = ($request->installment_time)?$request->installment_time:null;
        $payment->student_id = $student_id;

        if (isset($request->payment_screenshot)) {
			$uploads_dir = public_path().'/uploads/payment_slips';
			$tmp_name    = $_FILES['payment_screenshot']['tmp_name'];
			$fname       = $_FILES['payment_screenshot']['name'];
			$fextension  = explode(".", $fname);
			$filename    = "slip_".time().'.'.$fextension[1];
			move_uploaded_file($tmp_name, "$uploads_dir/$filename");

			$payment->payment_screenshot = $filename;
		}
        
        $payment->save();

        return response()->json($payment);
    }
}
