@extends('layouts.app')

@section('title'){!! "Courses -" !!} @stop
@section('og-title'){!! "Courses" !!} @stop

@section('content')

<div class="container main-content-bg courses-page pt-4">

    <div class="course-category-wrapper">
        <div class="row category-group">
            @foreach($course_categories as $cat)
            <div class="col-sm-6 col-12 course">
                <div class="card">
                    <a href="{{url('/courses/category/'.$cat->slug)}}" class="course-image">
                        @if(!empty($cat->image))
                            <img class="card-img-top w-100" src="{{url($cat->image)}}" alt="PSM Course">
                        @else
                            <img class="card-img-top w-100" src="{{url($setting->default_image)}}" alt="PSM Course Category">
                            {{-- <img class="card-img-top w-100" src="{{url('/assets/images/sample-course-img.jpg')}}" alt="PSM Course Category"> --}}
                        @endif
                    </a>
                    
                    <div class="card-body">
                      
                        <h5 class="card-title text-center"> 
                          <a class="course-cat" href="{{url('/courses/category/'.$cat->slug)}}">{{$cat->name}} </a>
                        </h5>
                      
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="course-section">
        
        <div class="row">
        <div class="col-12">
        <div id="courseControls" class="carousel slide" data-ride="carousel">
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
                                    </h5>

                                    <div class="course-image-wrapper">
                                        <a href="{{url('/courses/'.$course->slug)}}" class="course-image">
                                            @if(!empty($course->image))
                                                <img class="card-img-top w-100" src="{{url($course->image)}}" alt="PSM Course Image">
                                            @else
                                                <img class="card-img-top w-100" src="{{url($setting->default_image)}}" alt="PSM Course">
                                                {{-- <img class="card-img-top w-100" src="{{url('/assets/images/sample-course-img.jpg')}}" alt="PSM Course"> --}}
                                            @endif
                                            
                                        </a>

                                        <div class="fees"> {{$course->fees}} <br> {{$course->fees_type}} </div>
                                    </div>
                                    
                                    <div class="card-body">
            
                                    <div class="description mb-2"> 
                                        {!!str_replace(array("<p>","</span..."),array("<p align='justify'>","...</span>"),Str::limit($course->description, 90, $end='...'))!!}
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
            <a class="carousel-control-prev" href="#courseControls" role="button" data-slide="prev">
            <span class="carousel-nav d-flex align-items-center justify-content-center" aria-hidden="true">&lsaquo;</span>
            <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#courseControls" role="button" data-slide="next">
            <span class="carousel-nav d-flex align-items-center justify-content-center" aria-hidden="true">&rsaquo;</span>
            <span class="sr-only">Next</span>
            </a>
        </div>
        </div>

        </div>
    
    </div>

    <div class="bottom-bg-wrapper">
        <img src="{{asset('/assets/images/course-bottom-bg.png')}}" alt="Courses Background Image">
    </div>

</div>
@endsection

@push('scripts')
<script>

// document.addEventListener('DOMContentLoaded', function() {
//     var images = document.querySelectorAll(".card-img-top");

//     images.forEach((item) => {
//         var imgWidth = item.width;
//         var imgHeight = item.height;
        
//         if(imgWidth > imgHeight) {
//             item.height = imgWidth;
//         }
//     });
// }, false);

</script>
@endpush