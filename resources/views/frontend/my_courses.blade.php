@extends('layouts.app')

@section('title'){!! "MyCourses -" !!} @stop
@section('og-title'){!! "MyCourses" !!} @stop

@section('content')
<div class="container main-content-bg mycourses-page">

    <div class="course-section">
        <div class="row">
            @foreach($mycourses as $course)
            <div class="col-md-4 col-sm-6 col-12 mb-4 course">

                <div class="card">
                    <p class="course-cat-wrapper mb-0">
                        <a class="course-cat" href="{{url('/courses/category/'.$course->category->slug)}}">{{$course->category->name}} </a>
                    </p>
                    <h5 class="card-title">
                            <a href="{{url('/my_courses/detail/'.$course->slug)}}" class="course-title">
                                {{$course->course_name}}
                            </a> 
                        </h5>

                    <div class="course-image-wrapper">
                        <a href="{{url('/my_courses/detail/'.$course->slug)}}" class="course-image">
                            @if(!empty($course->image))
                                <img class="card-img-top w-100" src="{{url($course->image)}}" alt="PSM Course Image">
                            @else
                                <img class="card-img-top w-100" src="{{url($setting->default_image)}}" alt="PSM Course">
                                {{-- <img class="card-img-top w-100" src="{{url('/assets/images/sample-course-img.jpg')}}" alt="PSM Course"> --}}
                            @endif
                        </a>
                    </div>
                    
                    
                    {{-- <div class="card-body">

                        <div class="description mb-1"> 
                            {!!str_replace(array("<p>","</span..."),array("<p align='justify'>","...</span>"),Str::limit($course->description, 80, $end='...'))!!}
                        </div>

                        <div class="course-code"> {{$course->course_code}} </div>
                        
                    </div> --}}
                </div>
                
            </div>
            @endforeach
        </div>
    
        <div class="row">
            <div class="col-12">
                @if(count($mycourses) == 0)
                    <h2 class="text-center my-5 py-4">Empty Enrol Course!</h2>
                @endif
            </div>
        </div>
    </div>

    <div class="bottom-bg-wrapper">
        <img src="{{asset('/assets/images/mycourse-bottom-bg.png')}}" alt="Courses Background Image">
    </div>

</div>
@endsection
