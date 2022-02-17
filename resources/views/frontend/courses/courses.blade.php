@extends('layouts.app')

@section('title'){!! "Courses -" !!} @stop

@section('content')
<div class="container category-course-page py-4">
    <div class="row mb-3">
        <div class="col-12 px-5">
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary btn-back"> <i class="fas fa-long-arrow-alt-left"></i> Back </a>
            @can('list')
            <a href="/admin/category-course-management" target="_blank" class="btn btn-sm btn-primary" style="border-radius:50px;">Manage Course</a>
            <a href="/admin/courses/create" target="_blank" class="btn btn-sm btn-success" style="border-radius:50px;">Add Course</a>
            @endcan
            
        </div>
    </div>

    <div class="course-section">
        
        <div class="row">
            @foreach($courses as $course)
            <div class="col-md-4 col-sm-6 col-12 course mb-4">
                <div class="card">
                    <div class="card-inner">
                        <div class="fees"> <div class="fees-inner align-self-center">{{$course->fees}} <br> {{$course->fees_type}}</div> </div>

                        <p class="course-cat-wrapper mb-0">
                            <a class="course-cat" href="{{url('/courses/category/'.$course->category->slug)}}">{{$course->category->name}} </a>
                        </p>

                        <div class="course-image-wrapper">
                            <a href="{{url('/courses/'.$course->slug)}}" class="course-image">
                                @if(!empty($course->image))
                                    <img class="card-img-top w-100" src="{{url($course->image)}}" alt="PSM Course Image">
                                @else
                                    <img class="card-img-top w-100" src="{{url('/assets/images/sample-course-img.jpg')}}" alt="PSM Course">
                                @endif
                                
                            </a>

                        </div>
                        
                        <div class="card-body">
                            <h5 class="card-title"> 
                                <a href="{{url('/courses/'.$course->slug)}}" class="course-title">
                                    {{$course->course_name}}
                                </a>
                            </h5>

                            <div class="description mb-2"> 
                                {!!str_replace(array("<p>"),array("<p align='justify'>"),Str::limit($course->description, 80, $end='...'))!!}
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
            </div>
            @endforeach
        </div>

        {{-- <div class="row">
        <div class="col-12">
            <div id="catCourseControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    
                    @foreach($courses->chunk(3) as $courseCollections)
                        
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            
                            
                        </div>
                        
                    @endforeach
                    
                </div>
                <a class="carousel-control-prev" href="#catCourseControls" role="button" data-slide="prev">
                <span class="carousel-nav d-flex align-items-center justify-content-center" aria-hidden="true">&lsaquo;</span>
                <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#catCourseControls" role="button" data-slide="next">
                <span class="carousel-nav d-flex align-items-center justify-content-center" aria-hidden="true">&rsaquo;</span>
                <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        </div> --}}
    
    </div>

    {{-- @forelse($courses as $course)
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-12">
                    <a href="{{url('/courses/detail/'.$course->id)}}">
                        @if(!empty($course->image))
                        <img src="{{asset($course->image)}}" class="w-100" alt="PSM Course">
                        @else
                        <img src="{{url('/assets/images/sample-course-img.jpg')}}" class="w-100" alt="PSM Course">
                        @endif
                    </a>
                </div>
                <div class="col-md-9 col-sm-9 col-12">
                    <div class="fees"> {{$course->fees}} <br> {{$course->fees_type}} </div>
                    <p class="text-muted"> {{$course->category->name}} </p>
                    <a href="{{url('/courses/detail/'.$course->id)}}"><h5 class="course-title">{{$course->course_name}}</h5></a>
                    <div class="description mb-3"> 
                        {!!str_replace(array("<p>","</span..."),array("<p align='justify'>","...</span>"),Str::limit($course->description, 100, $end='...'))!!}
                    </div>


                    <div class="course-footer">
                        <a href="{{url('/payments?course_id='.$course->id)}}" class="btn btn-primary btn-sm brand-btn-color mr-auto">Enrol Here</a>

                        <div class="detail-link text-right ml-auto">
                          <a href="{{url('/courses/show/'.$course->id)}}" class="btn btn-primary btn-sm brand-btn-color">Details </a>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    @empty

    @endforelse --}}
</div>
@endsection

@push('styles')
<style>
    .course-page .fees {
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
    .course-footer {
        width: 95%;
        bottom: 0;
    }
</style>
@endpush