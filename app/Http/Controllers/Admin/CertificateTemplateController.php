<?php

namespace App\Http\Controllers\Admin;

use App\Models\CertificateTemplate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CertificateTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.certificate_templates.index');
    }

    public function landscape()
    {
        $certificate = CertificateTemplate::find(1);

        return view('admin.certificate_templates.landscape',compact('certificate'));
        // return view('admin.certificate_templates.landscape');
    }

    public function portrait()
    {
        $certificate = CertificateTemplate::find(2);

        return view('admin.certificate_templates.portrait', compact('certificate'));
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
            'background_image' => 'required',
        ]);

        $input = $request->except(['_token','certificate_type']);

        // $count = CertificateTemplate::count();

        // if($count == 0) {
            $certificate = CertificateTemplate::create($input);

            if($request->certificate_type == "landscape") {
                flash('Certificate landscape created successful!')->success()->important();
    
                return redirect()->route('certificate_templates.landscape');
            }else {
                flash('Certificate portrait created successful!')->success()->important();
                
                return redirect()->route('certificate_templates.portrait');
            }
        // }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CertificateTemplate  $certificateTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(CertificateTemplate $certificateTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CertificateTemplate  $certificateTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(CertificateTemplate $certificateTemplate)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CertificateTemplate  $certificateTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'background_image' => 'required',
        ]);
        
        $input = $request->except(['_token','certificate_type','_method']);
        
        $certificate = CertificateTemplate::where('id', $id)->update($input);
        
        if($request->certificate_type == "landscape") {
            flash('Certificate landscape updated successful!')->success()->important();

            return redirect()->route('certificate_templates.landscape');
        }else {
            flash('Certificate portrait updated successful!')->success()->important();
            
            return redirect()->route('certificate_templates.portrait');
        }

        // if($request->certificate_type == "landscape") {
        //     flash('Certificate under maintenance!')->warning()->important();

        //     return redirect()->route('certificate_templates.landscape');
        // }else {
        //     flash('Certificate portrait updated successful!')->success()->important();
            
        //     return redirect()->route('certificate_templates.portrait');
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CertificateTemplate  $certificateTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(CertificateTemplate $certificateTemplate)
    {
        //
    }
}
