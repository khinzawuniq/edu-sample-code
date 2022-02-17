@extends('layouts.app')

@section('title'){!! $course->course_name." -" !!} @stop

@section('og-title'){!! $course->course_name !!} @stop
@section('og-image'){!! $course->image? asset($course->image): asset($setting->default_image) !!} @stop
@section('meta-description'){{ $course->description }} @stop 

@section('content')
<div class="container course-show">

    <div class="card mb-4 course-card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-12">
                    <div class="course-image-wrapper">
                        @if($super_admin == true)
                            <a href="{{url('/courses/detail/'.$course->slug)}}">
                                @if(!empty($course->image))
                                <img src="{{asset($course->image)}}" class="w-100" alt="PSM Course">
                                @else
                                <img src="{{url($setting->default_image)}}" class="w-100" alt="PSM Course">
                                {{-- <img src="{{url('/assets/images/sample-course-img.jpg')}}" class="w-100" alt="PSM Course"> --}}
                                @endif
                            </a>
                        @else
                            @if($enrol_course == true)
                                <a href="{{url('/courses/detail/'.$course->slug)}}">
                                    @if(!empty($course->image))
                                    <img src="{{asset($course->image)}}" class="w-100" alt="PSM Course">
                                    @else
                                    <img src="{{url($setting->default_image)}}" class="w-100" alt="PSM Course">
                                    @endif
                                </a>
                            @else
                                <a href="{{url('/payments?course_id='.$course->id)}}">
                                    @if(!empty($course->image))
                                    <img src="{{asset($course->image)}}" class="w-100" alt="PSM Course">
                                    @else
                                    <img src="{{url($setting->default_image)}}" class="w-100" alt="PSM Course">
                                    @endif
                                </a>
                            @endif
                        @endif
                        

                        <div class="fees d-flex w-100"><span class="fees-inner w-100">{{$course->fees}} {{$course->fees_type}}</span> </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-12">

                    <p class="course-cat mb-0 text-muted"> {{$course->category->name}} </p>
                    {{-- <a href="{{url('/courses/detail/'.$course->id)}}"></a> --}}
                    <h5 class="course-title mb-2">{{$course->course_name}}</h5>

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
                        <a href="{{url('/courses/detail/'.$course->slug)}}" class="btn btn-warning btn-sm enrol-btn">MY COURSE</a>
                    @else
                        @if($enrol_course == true)
                        <a href="{{url('/courses/detail/'.$course->slug)}}" class="btn btn-warning btn-sm enrol-btn">MY COURSE</a>
                        @else 
                        <a href="{{url('/payments?course_id='.$course->id)}}" class="btn btn-warning btn-sm enrol-btn">ENROLL HERE</a>
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
    
</style>
@endpush