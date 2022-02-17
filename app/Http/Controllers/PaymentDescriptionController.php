<?php

namespace App\Http\Controllers;

use App\Models\PaymentDescription;
use Illuminate\Http\Request;

class PaymentDescriptionController extends Controller
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
        $request->validate([
            'pay_name' => 'required',
        ]);
        $data = $request->except('_token');
        $paymentDescription = PaymentDescription::create($data);

        flash('Payment Description Created Successful!')->success()->important();
        return redirect('/payments');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentDescription  $paymentDescription
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentDescription $paymentDescription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentDescription  $paymentDescription
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $paymentDescription = PaymentDescription::find($id);

        return response($paymentDescription);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentDescription  $paymentDescription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'pay_name' => 'required',
        ]);
        
        $paymentDescription = PaymentDescription::find($request->pay_id);
        $paymentDescription->pay_name = $request->pay_name;
        $paymentDescription->save();

        flash('Payment Description Updated Successful!')->success()->important();
        return redirect('/payments');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentDescription  $paymentDescription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $paymentDescription = PaymentDescription::find($request->id)->delete();

        flash('Payment Description Deleted Successful!')->success()->important();
        return redirect('/payments');
    }
}
