<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class StartController extends Controller
{
    public function start()
    {
        if(Auth::check()) {
            return redirect()->route('home');
        }
        return view('frontend.index');
    }
}
