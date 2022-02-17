@extends('layouts.app')

@section('title'){!! $course->course_name." -" !!} @stop

@section('og-title'){!! $course->course_name !!} @stop
@section('og-image'){!! $course->image? asset($course->image):asset($setting->default_image) !!} @stop
@section('meta-description'){!! $course->description !!}  @stop 

@section('content')
<div class="container course-show py-4">

    <div class="card mb-4 course-card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-12">
                    <a href="{{url('/courses/detail/'.$course->slug)}}">
                        @if(!empty($course->image))
                        <img src="{{asset($course->image)}}" class="w-100" alt="PSM Course">
                        @else
                        <img src="{{url($setting->default_image)}}" class="w-100" alt="PSM Course">
                        @endif
                    </a>
                </div>
                <div class="col-md-8 col-sm-8 col-12">
                    <div class="fees"> {{$course->fees}} <br> {{$course->fees_type}} </div>

                    <p class="text-muted"> {{$course->category->name}} </p>
                    <a href="{{url('/my_courses/detail/'.$course->slug)}}"><h5 class="course-title mb-4">{{$course->course_name}}</h5></a>

                    <div class="description mb-3"> 
                        {!! $course->description !!}
                    </div>

                    <div class="enrol-total mr-auto">
                        <span><i class="fas fa-user-friends"></i> 
                            @if($course->enable_enrol_no == true)
                                {{$course->enrol_no}} Students
                            @else
                                {{count($course->enrolUser)}} Students
                            @endif
                        </span>
                    </div>

                    @if($super_admin == true)
                        <a href="{{url('/my_courses/detail/'.$course->slug.'/'.Auth::id())}}" class="btn btn-primary btn-sm enrol-btn">My Course</a>
                    @else
                        @if($enrol_course == true)
                        <a href="{{url('/my_courses/detail/'.$course->slug.'/'.Auth::id())}}" class="btn btn-primary btn-sm enrol-btn">My Course</a>
                        @else 
                        <a href="{{url('/payments?course_id='.$course->id)}}" class="btn btn-primary btn-sm enrol-btn">Enrol Here</a>
                        @endif
                    @endif
                    
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
    .course-card .fees {
        background-color: rgba(1,1,209, 0.8);
        color: #fff;
        font-size: .7rem;
        position: absolute;
        right: 17px;
        top: 0;
        padding: 14px 0 0;
        text-align: center;
        width: 60px;
        height: 60px;
        border-radius: 50%;
    }
    .enrol-btn {
        background-color: #021f63;
        position: absolute;
        right: 15px;
        bottom: 0;
    }
</style>
@endpush