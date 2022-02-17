@extends('layouts.app')

@section('content')
<div class="container course-categories-page py-4">

    <div class="row">
        @foreach($course_categories as $cat)
        <div class="col-md-4 col-sm-6 col-12 mb-5 course">
            <div class="card">
                <a href="{{url('/courses/category/'.$cat->slug)}}" class="course-image">
                    @if(!empty($cat->image))
                        <img class="card-img-top w-100" src="{{url($cat->image)}}" alt="PSM Course">
                    @else
                        <img class="card-img-top w-100" src="{{url('/assets/images/sample-course-img.jpg')}}" alt="PSM Course Category">
                    @endif
                    
                </a>
                
                <div class="card-body">
                  <p class="text-muted"> Modified {{date('d F Y', strtotime($cat->updated_at))}} </p>
                  <h5 class="card-title"> {{$cat->name}} </h5>

                  {{-- <p class="count-course">{{count($cat->courses)}} Courses</p> --}}
                  <div class="description"> 
                    {!!str_replace(array("<p>","</span..."),array("<p align='justify'>","...</span>"),Str::limit($cat->description, 100, $end='...'))!!}
                  </div>
                  
                  <div class="course-footer category-course">
                    <div class="enrol-total mr-auto">
                        <span><i class="fas fa-user-friends"></i> 
                            {{count($cat->courses)}} Courses
                        </span>
                    </div>

                    <div class="detail-link text-right ml-auto">
                        <a href="{{url('/courses/category/'.$cat->id)}}" class="btn btn-primary btn-sm brand-btn-color">Detail</a>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
