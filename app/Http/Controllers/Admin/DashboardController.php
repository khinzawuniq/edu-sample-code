<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Course;
use App\Models\CourseCategory;
use Auth;

class DashboardController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:list|create|edit|delete', ['only' => ['index','store']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::find(Auth::id());
        if($user->hasRole(['Student'])) {
            return redirect('/home');
        }

        $users = User::All();
        $total_students = $users->where('role','Student')->count();
        $total_teachers = $users->where('role','!=','Student')->count();

        $total_courses = Course::count();
        $total_programmes = CourseCategory::count();
        
        return view('admin.dashboard.index',compact('total_students','total_teachers','total_courses','total_programmes'));
    }
}
