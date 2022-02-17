<?php

namespace App\Http\Controllers\Admin;

use App\Models\CampusAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CampusAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campus_address = CampusAddress::orderBy('id','desc')->get();
        
        return view('admin.campus_address.index', compact('campus_address'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.campus_address.create');
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
            'campus_name'   => 'required',
            'address'       => 'required',
            'phone'         => 'required',
            'email'         => 'required',
        ]);

        $input = $request->except(['_token']);

        $campusAddress = CampusAddress::create($input);

        flash('Campus '.$campusAddress->campus_name.' created successful!')->success()->important();
    
        return redirect('/admin/campus_address');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CampusAddress  $campusAddress
     * @return \Illuminate\Http\Response
     */
    public function show(CampusAddress $campusAddress)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CampusAddress  $campusAddress
     * @return \Illuminate\Http\Response
     */
    public function edit(CampusAddress $campusAddress)
    {
        return view('admin.campus_address.edit', compact('campusAddress'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CampusAddress  $campusAddress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CampusAddress $campusAddress)
    {
        $this->validate($request, [
            'campus_name'   => 'required',
            'address'       => 'required',
            'phone'         => 'required',
            'email'         => 'required',
        ]);

        $input = $request->except(['_token']);

        $campusAddress->update($input);

        flash('Campus '.$campusAddress->campus_name.' updated successful!')->success()->important();
    
        return redirect('/admin/campus_address');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CampusAddress  $campusAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(CampusAddress $campusAddress)
    {
        $campusAddress->delete();

        return redirect('/admin/campus_address');
    }

    public function active($id)
    {
        CampusAddress::where('id', $id)->update([
            'is_active' => true
        ]);
        return response()->json([
            'code' => 200,
            'message' => 'Successful Active',
        ]);
    }
    
    public function inactive($id)
    {
        CampusAddress::where('id', $id)->update([
            'is_active' => false
        ]);
        return response()->json([
            'code' => 200,
            'message' => 'Successful Inactive',
        ]);
    }

}
