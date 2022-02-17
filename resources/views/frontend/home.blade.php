@extends('layouts.app')

@section('og-image'){!! asset($slideshows[0]->slide_photo) !!} @stop

@section('content')

@include('frontend.slideshow')

<div class="container main-content-bg home-page pb-3">
    <div class="course-section py-5 mb-2">
        <div class="row">
            <div class="col">
                <h3 class="block-title mb-4">POPULAR COURSES</h3>
            </div>
            <div class="col text-right">
                <a href="{{url('/courses')}}" class="view-all-link">View All Courses</a>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
            <div id="carouselCourseControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">

                @foreach($courses->chunk(3) as $courseCollections)
                    
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        
                        <div class="row">
                            @foreach($courseCollections as $course)
                            <div class="col-md-4 col-sm-6 col-12 course">
                                <div class="card" >
                                    <p class="course-cat-wrapper mb-0">
                                        <a class="course-cat" href="{{url('/courses/category/'.$course->category->slug)}}">{{$course->category->name}} </a>
                                    </p>
                                    <h5 class="card-title"> 
                                        <a href="{{url('/courses/'.$course->slug)}}" class="course-title">
                                            {{$course->course_name}}
                                        </a>
                                        {{-- @if($course->course_code)
                                        <span class="course-code"> ( {{$course->course_code}} ) </span>
                                        @endif --}}
                                    </h5>

                                    <div class="course-image-wrapper">
                                        <a href="{{url('/courses/'.$course->slug)}}" class="course-image">
                                            @if(!empty($course->image))
                                                <img class="card-img-top w-100" src="{{url($course->image)}}" alt="PSM Course Image">
                                            @else
                                                <img class="card-img-top w-100" src="{{url('/assets/images/sample-course-img.jpg')}}" alt="PSM Course">
                                            @endif
                                            
                                        </a>

                                        <div class="fees"> {{$course->fees}} <br> {{$course->fees_type}} </div>
                                    </div>
                                    
                                    <div class="card-body">
            
                                    <div class="description mb-2"> 
                                        {{-- {!! Str::limit($course->description, 80, $end='...') !!} --}}
                                        {!! str_replace(array("<p>","</span..."),array("<p align='justify'>","...</span>"),Str::limit($course->description, 80, $end='...')) !!}
                                    </div>
                                    
                                    <div class="course-footer">
                                        
                                        <a href="{{url('/payments?course_id='.$course->id)}}" class="btn btn-warning btn-sm brand-btn-gold mr-auto">Enroll Here</a>
            
                                        <div class="detail-link text-right ml-auto">
                                            <a href="{{url('/courses/'.$course->slug)}}" class="btn btn-warning btn-sm brand-btn-gold">See More... </a>
                                        </div>
                                    </div>
            
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                @endforeach
                
                </div>
            <a class="carousel-control-prev" href="#carouselCourseControls" role="button" data-slide="prev">
            {{-- <span class="carousel-control-prev-icon carousel-nav" aria-hidden="true"></span> --}}
            <span class="carousel-nav d-flex align-items-center justify-content-center" aria-hidden="true">&lsaquo;</span>
            <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselCourseControls" role="button" data-slide="next">
            {{-- <span class="carousel-control-next-icon carousel-nav" aria-hidden="true"></span> --}}
            <span class="carousel-nav d-flex align-items-center justify-content-center" aria-hidden="true">&rsaquo;</span>
            <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
        </div>
    
    </div>
    
</div>
@endsection

@push('styles')
<style>
    .course-section {
        margin-bottom: 30px !important;
    }
    #carouselCourseControls .carousel-control-prev {
        top: auto;
        bottom: -55px;
        left: 45.5%;
    }
    #carouselCourseControls .carousel-control-next {
        top: auto;
        bottom: -55px;
        right: 45.5%;
    }
</style>
@endpush

@push('scripts')
<script src="{{asset('/js/device-uuid/device-uuid.js')}}" type="text/javascript"></script>
<script>

</script>
@endpush